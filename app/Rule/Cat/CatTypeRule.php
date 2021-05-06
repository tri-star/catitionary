<?php

declare(strict_types=1);

namespace App\Rule\Cat;

use App\Domain\CatType;
use Illuminate\Contracts\Validation\Rule;

class CatTypeRule implements Rule
{
    public function passes($attribute, $value)
    {
        $values = is_array($value) ? $value : [$value];
        $count = CatType::query()->whereIn('key', $values)->count();
        return $count === count($values);
    }


    public function message()
    {
        return ':attribute の指定が無効です。';
    }
}
