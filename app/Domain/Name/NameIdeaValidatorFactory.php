<?php

declare(strict_types=1);

namespace App\Domain\Name;

use App\Rule\Cat\CatCharactericsRule;
use App\Rule\Cat\CatTypeRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

/**
 * 名前提案のバリデータを生成するクラス
 */
class NameIdeaValidatorFactory
{
    public static function fromApiInput($name, $types, $characters): Validator
    {
        $maxNameLength = NameIdea::NAME_MAX_LENGTH;

        return ValidatorFacade::make([
            'name'       => $name,
            'types'      => $types,
            'characters' => $characters,
        ], [
            'name'       => "required|max:{$maxNameLength}",
            'types'      => [
                'array',
                new CatTypeRule(),
            ],
            'characters' => [
                'array',
                new CatCharactericsRule(),
            ],
        ]);
    }
}
