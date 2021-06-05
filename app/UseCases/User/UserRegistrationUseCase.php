<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Domain\UseCaseResult;
use App\Domain\User\User;

class UserRegistrationUseCase
{
    public function execute(array $data): UseCaseResult
    {
        $user = new User([
            'name'     => '',
            'email'    => $data['email'],
            'login_id' => $data['login_id'],
            'password' => $data['password'],
        ]);

        $user->save();

        return new UseCaseResult(true);
    }
}
