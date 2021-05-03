<?php

declare(strict_types=1);

namespace App\Rule\Cat;

use App\Domain\CatType;
use Illuminate\Contracts\Validation\Rule;

class CatTypeRule implements Rule
{
    public function passes($attribute, $value)
    {
        $catType = CatType::query()->where('key', $value)->first();
        return $catType ? true : false;
    }


    public function message()
    {
        return ':attribute の指定が無効です。';
    }
}
