<?php

namespace App\Modules\Member\Http\Controllers;

use App\Repositories\ContactRepository;
use App\Repositories\MessageRepository;
use App\Validators\BaseValidatorInterface;
use App\Validators\ContactValidator;
use App\Validators\MessageValidator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class ContactController extends AppController
{

    protected $contactRepository;
    protected $contactValidator;
    protected $messageRepository;
    protected $messageValidator;


    public function __construct(
        ContactRepository $contactRepository,
        ContactValidator $contactValidator,
        MessageRepository $messageRepository,
        MessageValidator $messageValidator
    )
    {
        parent::__construct();

        $this->contactRepository = $contactRepository;
        $this->contactValidator  = $contactValidator;
        $this->messageRepository = $messageRepository;
        $this->messageValidator  = $messageValidator;
    }


    /**
     * Contact get list api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $member     = auth()->guard('api')->user();

        $conditions = [
            'contacts.member_id' => $member->id
        ];

        $list = $this->contactRepository->scopeQuery(function ($query) use ($conditions) {
            return $query->select(
                    'contacts.id',
                    'contacts.friend_id',
                    'contacts.group_id',
                    'members.avatar',
                    DB::raw('(CASE WHEN contacts.friend_id IS NULL THEN \'category\' ELSE \'friend\' END) AS contact_type'),
                    DB::raw('(CASE WHEN groups.name IS NULL THEN members.name ELSE groups.name END) AS contact_name')
                )
                ->leftJoin('groups', 'contacts.group_id', '=', 'groups.id')
                ->leftJoin('members', 'contacts.friend_id', '=', 'members.id')
                ->where($conditions)
                ->orderBy('action_at', 'desc');
        });

        $output = $list->all();
        $output->each(function ($contact) {
            $contact->load('message');
        });

        return $this->jsonResponse(STATUS_OK, __('List contact'), $output);
    }


    /**
     * Contact get messages api
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $profile = auth()->guard('api')->user();
        $profile->load('contact', 'setting');

        $contact = $this->contactRepository->findWhere(
            ['id' => $id],
            ['id', 'member_id', 'friend_id', 'group_id']
        )->first();

        $messages = $this->messageRepository->with('member:id,username,name,avatar')->findWhere(
            ['contact_id' => $id],
            ['id', 'contact_id', 'member_id', 'content']
        );

        $contact['messages'] = !empty($messages) ? $messages : [];

        $output = [
            'profile'   => $profile,
            'contact'   => $contact
        ];

        return $this->jsonResponse(STATUS_OK, __('Message list'), $output);
    }


    /**
     * Contact send message api
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function message(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $member = auth()->guard('api')->user();

            $messageData = [
                'contact_id'    => $id,
                'member_id'     => $member->id,
                'content'       => $request->has('content') ? $request->get('content') : null
            ];

            $this->messageValidator->with($messageData)->passesOrFail(BaseValidatorInterface::RULE_CREATE);

            $contacts   = [];
            $contacts[] = $this->contactRepository->findWhere(['id' => $id])->first();

            if (!empty($contacts[0]->friend_id)) {
                $friendContact = $this->contactRepository->findWhere([
                    'member_id' => $contacts[0]->friend_id,
                    'friend_id' => $contacts[0]->member_id
                ])->first();

                if (!empty($friendContact)) {
                    $contacts[] = $friendContact;
                }
            } else {
                $contacts = $this->contactRepository->findWhere(['group_id' => $contacts[0]->group_id]);
            }

            foreach ($contacts as $contact) {
                $messageData['contact_id']  = $contact->id;
                $messageData['member_id']   = $member->id;

                if ($this->messageRepository->create($messageData)) {
                    $contact->action_at = date('Y-m-d H:i:s');
                    $contact->save();
                }
            }

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Send message success'), []);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }

}
