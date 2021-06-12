<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Internal\User;

use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;
use App\UseCases\User\UserExistenceCheckUseCase;
use Illuminate\Http\Request;

class ExistAction extends Controller
{
    public function invoke(Request $request, UserExistenceCheckUseCase $useCase)
    {
        $loginId = $request->input('login_id', '');
        $result = $useCase->executeByLoginId($loginId);

        return new JsonResponse([
            'exist' => $result->get('exist', false),
        ]);
    }
}
