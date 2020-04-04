<?php

namespace App\Modules\Member\Http\Controllers;

use App\Repositories\GroupRepository;
use App\Validators\BaseValidatorInterface;
use App\Validators\GroupValidator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

class GroupController extends AppController
{

    protected $groupRepository;
    protected $groupValidator;


    public function __construct(
        GroupRepository $groupRepository,
        GroupValidator $groupValidator
    )
    {
        parent::__construct();

        $this->groupRepository = $groupRepository;
        $this->groupValidator  = $groupValidator;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = auth()->guard('api')->user();
            $request->merge(['member_id' => $member->id]);

            $this->groupValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_CREATE);

            $data = [
                'member_id' => $request->get('member_id'),
                'name'      => $request->get('name'),
            ];

            $group = $this->groupRepository->create($data);
            //add group to table contacts
            $member->groups()->attach($group->id);

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Add new group success'), $group);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }

}
