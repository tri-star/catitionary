<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Name;

use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;
use App\UseCases\Name\SubmitNameUseCase;
use Illuminate\Http\Request;

class SubmitNameAction extends Controller
{
    public function invoke(SubmitNameUseCase $useCase, Request $request)
    {
        $result = $useCase->execute(
            $request->json('name'),
            $request->json('types'),
            $request->json('characters'),
        );

        if (!$result->success) {
            new JsonResponse([], 400);
        }
        return new JsonResponse([]);
    }
}
