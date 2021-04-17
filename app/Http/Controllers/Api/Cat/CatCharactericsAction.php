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
        $array = [];
        foreach (CatCharacterics::getList() as $key=>$value) {
            $array[] = [
                'id'   => $key,
                'name' => $value,
            ];
        }
        return new JsonResponse($array);
    }
}
