<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;
use App\UseCases\User\VerifyEmailUseCase;
use Illuminate\Http\Request;

class VerifyEmailAction extends Controller
{
    public function invoke(Request $request, VerifyEmailUseCase $useCase)
    {
        $code = $request->query('code') ?? '';
        $result = $useCase->execute($code);

        if (!$result->success) {
            return new JsonResponse([], 422);
        }
        return new JsonResponse([]);
    }
}
