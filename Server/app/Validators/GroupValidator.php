<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class GroupValidator.
 *
 * @package namespace App\Validators;
 */
class GroupValidator extends LaravelValidator
{

    /**
     * GroupValidator constructor.
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
                'name'      => 'required',
                'member_id' => 'required|exists:members,id',
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
