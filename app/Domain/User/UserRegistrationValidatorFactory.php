<?php

declare(strict_types=1);

namespace App\Domain\User;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Validator;

/**
 * 名前提案のバリデータを生成するクラス
 */
class UserRegistrationValidatorFactory
{
    public static function fromApiInput($email, $loginId, $password): Validator
    {
        $maxEmailLength = User::MAX_EMAIL_LENGTH;
        $maxLoginIdLength = User::MAX_LOGIN_ID_LENGTH;
        $maxPasswordLength = User::MAX_PASSWORD_LENGTH;
        $minPasswordLength = User::MIN_PASSWORD_LENGTH;

        return ValidatorFacade::make([
            'email'    => $email,
            'login_id' => $loginId,
            'password' => $password,
        ], [
            'email'    => "required|max:{$maxEmailLength}|unique:users,email",
            'login_id' => "required|max:{$maxLoginIdLength}|unique:users,login_id",
            'password' => "required|min:{$minPasswordLength}|max:{$maxPasswordLength}",
        ]);
    }
}
