<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use App\Domain\Name\NameIdea;
use App\Domain\Name\NamePattern;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NameIdeaTest extends TestCase
{
    use RefreshDatabase;

    public function test__relation__catTypes()
    {
        /** @var NameIdea $nameIdea */
        $nameIdea = NameIdea::factory()->has(CatType::factory())->create();

        $this->assertEquals(1, $nameIdea->catTypes->count());
    }


    public function test__relation__catCharacterics()
    {
        /** @var NameIdea $nameIdea */
        $nameIdea = NameIdea::factory()->has(CatCharacterics::factory())->create();

        $this->assertEquals(1, $nameIdea->catCharacterics->count());
    }


    public function test__relation__namePattern()
    {
        /** @var NameIdea $nameIdea */
        $nameIdea = NameIdea::factory()->has(NamePattern::factory())->create();

        $this->assertEquals(1, $nameIdea->namePattern->count());
    }
}
