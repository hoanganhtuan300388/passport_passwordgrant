<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class MemberContactValidator.
 *
 * @package namespace App\Validators;
 */
class MemberContactValidator extends LaravelValidator
{

    /**
     * MemberContactValidator constructor.
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
                'email'         => 'required|email|max:200|unique:member_contacts',
                'mobile_phone'  => 'nullable|string|max:12',
                'home_phone'    => 'nullable|string|max:12',
                'office_phone'  => 'nullable|string|max:12',
            ],
            BaseValidatorInterface::RULE_UPDATE => [
                'email'         => 'required|email|max:200|unique:member_contacts,email,' . $this->id,
                'mobile_phone'  => 'nullable|string|max:12',
                'home_phone'    => 'nullable|string|max:12',
                'office_phone'  => 'nullable|string|max:12',
            ],
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
        $this->messages = [];
    }

}
