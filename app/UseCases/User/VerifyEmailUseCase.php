<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Domain\UseCaseResult;
use App\Domain\User\User;
use Illuminate\Support\Carbon;

class VerifyEmailUseCase
{
    public function execute(string $code): UseCaseResult
    {
        $user = User::byEmailVerificationCode($code)->first();

        if (!$user) {
            return new UseCaseResult(false);
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return new UseCaseResult(true);
    }
}
