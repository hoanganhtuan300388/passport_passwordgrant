<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class MemberValidator.
 *
 * @package namespace App\Validators;
 */
class MemberValidator extends LaravelValidator
{

    /**
     * MemberValidator constructor.
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        /**
         *
         * Validator rules
         *
         */
        $this->rules = [
            BaseValidatorInterface::RULE_CREATE => [
            ],
            BaseValidatorInterface::RULE_UPDATE => [
            ],
            BaseValidatorInterface::RULE_MEMBER_LOGIN => [
                'username'  => 'required',
                'password'  => 'required',
            ],
            BaseValidatorInterface::RULE_MEMBER_REGISTER => [
                'username'  => 'required|string|max:100|unique:members',
                'password'  => 'required|string|min:8|max:255|confirmed',
                'name'      => 'required|string|max:100',
                'avatar'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'city'      => 'nullable|string|max:255',
                'country'   => 'nullable|string|max:255',
                'birthday'  => 'nullable|date',
                'gender'    => 'nullable|in:male,female,other',
                'status'    => 'nullable|in:verify,active',
                'email'     => 'required|email|max:200|unique:member_contacts',
            ],
            BaseValidatorInterface::RULE_MEMBER_EDIT_PROFILE => [
                'name'      => 'required|string|max:100',
                'avatar'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'city'      => 'nullable|string|max:255',
                'country'   => 'nullable|string|max:255',
                'birthday'  => 'nullable|date',
                'gender'    => 'nullable|in:male,female,other',
                'status'    => 'nullable|in:verify,active',
            ],
            BaseValidatorInterface::RULE_MEMBER_ADD_FRIEND => [
                'friend_id' => 'required|exists:members,id|friend_exists',
            ],
            BaseValidatorInterface::RULE_MEMBER_ADD_GROUP => [
                'member_id' => 'required|exists:members,id|member_exists',
                'group_id'  => 'required|exists:members,id|member_creator',
            ]
        ];

        /**
         *
         * Validator attributes
         *
         */
        $this->attributes = [
        ];

        /**
         *
         * Validator messages
         *
         */
        $this->messages = [
            'friend_id.friend_exists' => __('The :attribute has already been taken.'),
            'member_id.member_exists' => __('The :attribute has already been taken.'),
            'group_id.member_creator' => __('The :group_id not created by you.'),
        ];
    }

}
