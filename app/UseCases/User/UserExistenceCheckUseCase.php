<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Domain\UseCaseResult;
use App\Domain\User\User;

class UserExistenceCheckUseCase
{
    public function executeByLoginId(string $loginId): UseCaseResult
    {
        $user = User::byLoginId($loginId)->first();

        return new UseCaseResult(true, [
            'exist' => is_null($user) ? false : true,
        ]);
    }
}
