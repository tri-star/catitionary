<?php

declare(strict_types=1);

namespace App\UseCases\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use App\Domain\Name\NameIdea;
use App\Domain\Name\NameIdeaValidatorFactory;
use App\Domain\UseCaseResult;
use App\Validation\ValidationResult;

/**
 * 単体の名前案を登録する
 */
class SubmitNameSubUseCase
{
    /**
     * @var string|null $name
     * @var string[]|null $ypes
     * @var string[]|null $characters
     */
    public function execute($name, $types, $characters)
    {
        $validator = NameIdeaValidatorFactory::fromApiInput($name, $types, $characters);
        if ($validator->fails()) {
            return new UseCaseResult(false, [], ValidationResult::fromValidator($validator));
        }

        $catTypes = CatType::whereIn('key', $types)->get();
        $catCharacters = CatCharacterics::whereIn('key', $characters)->get();

        /** @var NameIdea $nameIdea */
        $nameIdea = NameIdea::create([
            'name' => $name,
        ]);

        foreach ($catTypes as $catType) {
            $nameIdea->catTypes()->attach($catType->id);
        }
        foreach ($catCharacters as $catCharacter) {
            $nameIdea->catCharacterics()->attach($catCharacter->id);
        }

        return new UseCaseResult(true, [
            'id' => $nameIdea->id,
        ]);
    }
}
