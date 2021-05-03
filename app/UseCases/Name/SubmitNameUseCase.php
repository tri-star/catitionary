<?php

declare(strict_types=1);

namespace App\UseCases\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use App\Domain\Name\NameIdea;
use App\Domain\Name\NameIdeaValidatorFactory;
use App\Domain\UseCaseResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubmitNameUseCase
{
    /**
     * @var string|null $name
     * @var string[]|null $ypes
     * @var string[]|null $characters
     */
    public function execute(?string $name, ?array $types, ?array $characters)
    {
        $validator = NameIdeaValidatorFactory::fromApiInput($name, $types, $characters);
        if ($validator->fails()) {
            Log::debug($validator->failed());
            return new UseCaseResult(false, [], $validator->failed());
        }

        /** @var NameIdea $nameIdea */
        $nameIdea = null;
        DB::transaction(function () use (&$nameIdea, $name, $types, $characters) {
            $catTypes = CatType::whereIn('key', $types)->get();
            $catCharacters = CatCharacterics::whereIn('key', $characters)->get();

            $nameIdea = NameIdea::create([
                'name' => $name,
            ]);

            foreach ($catTypes as $catType) {
                $nameIdea->catTypes()->attach($catType->id);
            }
            foreach ($catCharacters as $catCharacter) {
                $nameIdea->catCharacterics()->attach($catCharacter->id);
            }
        });

        return new UseCaseResult(true, [
            'id' => $nameIdea->id,
        ]);
    }
}
