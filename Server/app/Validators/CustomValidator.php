<?php

namespace App\Validators;

use App\Repositories\ContactRepository;
use App\Repositories\GroupRepository;

class CustomValidator
{

    protected $groupRepository;
    protected $contactRepository;

    public function __construct(
        GroupRepository $groupRepository,
        ContactRepository $contactRepository
    ) {
        $this->groupRepository      = $groupRepository;
        $this->contactRepository    = $contactRepository;
    }


    /**
     * check friend is exists in list friends
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function checkFriendExists($attribute, $value, $parameters, $validator)
    {
        $data       = $validator->getData();
        $contact    = $this->contactRepository->findWhere([
            'member_id' => auth()->guard('api')->user()->id,
            'friend_id' => $data['friend_id'],
        ])->first();

        return !empty($contact) ? false : true;
    }


    /**
     * check friend is exists in list friends
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function checkMemberExists($attribute, $value, $parameters, $validator)
    {
        $data       = $validator->getData();

        if (!empty($data['member_id']) && !empty($data['group_id'])) {
            $contact = $this->contactRepository->findWhere([
                'member_id' => $data['member_id'],
                'group_id' => $data['group_id'],
            ])->first();

            return !empty($contact) ? false : true;
        }

        return true;
    }


    /**
     * check friend is exists in list friends
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function checkMemberCreator($attribute, $value, $parameters, $validator)
    {
        $data   = $validator->getData();
        $group  = $this->groupRepository->findWhere([
            'id'        => $data['group_id'],
            'member_id' => auth()->guard('api')->user()->id,
        ])->first();

        return empty($group) ? false : true;
    }

}