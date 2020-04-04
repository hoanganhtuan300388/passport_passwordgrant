<?php

namespace App\Modules\Member\Http\Controllers;

use App\Repositories\ContactRepository;
use App\Validators\ContactValidator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ContactController extends AppController
{

    protected $contactRepository;
    protected $contactValidator;


    public function __construct(
        ContactRepository $contactRepository,
        ContactValidator $contactValidator
    )
    {
        parent::__construct();

        $this->contactRepository = $contactRepository;
        $this->contactValidator  = $contactValidator;
    }


    /**
     * Member get list contact api
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
            return $query
                ->select(
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

        return $this->jsonResponse(STATUS_OK, __('List contact'), $output);
    }

}
