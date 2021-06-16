<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Domain\UseCaseResult;
use App\Domain\User\User;
use App\Domain\User\UserRegistrationValidatorFactory;
use App\Notifications\EmailVerification;
use App\Validation\ValidationResult;

class UserRegistrationUseCase
{
    public function execute(array $data): UseCaseResult
    {
        $user = new User([
            'name'     => '',
            'email'    => $data['email'] ?? '',
            'login_id' => $data['login_id'] ?? '',
            'password' => $data['password'] ?? '',
        ]);

        $validator = UserRegistrationValidatorFactory::fromApiInput(
            $user->email,
            $user->login_id,
            $data['password'] ?? '',
        );


        if ($validator->fails()) {
            return new UseCaseResult(false, [], ValidationResult::fromValidator($validator));
        }

        $user->email_verification_code = User::generateEmailVerificationCode();
        $user->save();

        $user->notify(new EmailVerification());

        return new UseCaseResult(true);
    }
}
