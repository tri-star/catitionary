<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Cat;

use App\Domain\CatType;
use App\Http\Controllers\Controller;
use App\Http\Response\JsonResponse;

class CatTypesAction extends Controller
{
    public function invoke()
    {
        $array = [];
        foreach (CatType::getList() as $key=>$value) {
            $array[] = [
                'id'   => $key,
                'name' => $value,
            ];
        }
        return new JsonResponse($array);
    }
}
