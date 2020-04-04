<?php

namespace App\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

interface BaseValidatorInterface extends ValidatorInterface
{

    const RULE_MEMBER_LOGIN         = 'member_login';

    const RULE_MEMBER_REGISTER      = 'member_register';

    const RULE_MEMBER_EDIT_PROFILE  = 'member_edit_profile';

    const RULE_MEMBER_ADD_FRIEND    = 'member_add_friend';

    const RULE_MEMBER_ADD_GROUP     = 'member_add_group';

}