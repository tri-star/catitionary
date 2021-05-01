<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Cat;

use App\Domain\CatCharacterics;
use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;

class CatCharactericsAction extends Controller
{
    public function invoke()
    {
        $responseJson = CatCharacterics::all()->map(function ($row) {
            return [
                'id'   => $row->key,
                'name' => $row->name,
            ];
        });
        return new JsonResponse($responseJson);
    }
}
