<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class MemberSettingValidator.
 *
 * @package namespace App\Validators;
 */
class MemberSettingValidator extends LaravelValidator
{

    /**
     * MemberSettingValidator constructor.
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
