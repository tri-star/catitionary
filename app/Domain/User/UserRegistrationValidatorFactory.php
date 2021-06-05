<?php

declare(strict_types=1);

namespace App\Domain\User;

use Domain\User\User;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Validator;

/**
 * 名前提案のバリデータを生成するクラス
 */
class UserRegistrationValidatorFactory
{
    public static function fromApiInput($email, $loginId, $password): Validator
    {
        return ValidatorFacade::make([
            'email'    => $email,
            'login_id' => $loginId,
            'password' => $password,
        ], [
        ]);
    }
}
