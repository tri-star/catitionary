<?php

declare(strict_types=1);

namespace App\Domain\Name;

use App\Rule\Cat\CatTypeRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

/**
 * 名前提案のバリデータを生成するクラス
 */
class NameIdeaValidatorFactory
{
    public static function fromApiInput(?string $name, ?array $types, ?array $characters): Validator
    {
        return ValidatorFacade::make([
            'name'       => $name,
            'types'      => $types,
            'characters' => $characters,
        ], [
            'name'       => 'required',
            'types'      => [
                'array',
                new CatTypeRule(),
            ],
            'characters' => 'array',
        ]);
    }
}
