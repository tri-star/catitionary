<?php

declare(strict_types=1);

namespace App\Domain\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;

class NameIdea
{
    /** @var string $name 名前の案 */
    private $name;

    /** @var CatType[] 猫の種類 */
    private array $types;

    /** @var CatCharacterics[] 猫の特徴 */
    private array $characters;


    /**
     * @var string $name
     * @var CatType[] 猫の種類
     * @var CatCharacterics 猫の特徴
     */
    public function __construct(string $name, array $types, array $characters)
    {
        $this->name = $name;
        $this->types = $types;
        $this->characters = $characters;
    }


    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return CatType[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }


    /**
     * @return CatCharacterics[]
     */
    public function getCharacters(): array
    {
        return $this->characters;
    }
}
