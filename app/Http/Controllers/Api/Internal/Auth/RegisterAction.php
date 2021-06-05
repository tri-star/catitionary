<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;
use App\UseCases\User\UserRegistrationUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterAction extends Controller
{
    public function invoke(Request $request, UserRegistrationUseCase $useCase)
    {
        $result = $useCase->execute($request->json()->all());
        if (!$result->success) {
            return new JsonResponse([
                $result->validationResult->getErrors(),
            ], 400);
        }
        return response('', 200);
    }
}
