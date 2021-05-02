<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use App\UseCases\Name\SubmitNameUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmitNameUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @var SubmitNameUseCase $useCase  */
    private $useCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->useCase = new SubmitNameUseCase();
    }

    public function test__登録成功()
    {
        // 指定したtypes, charactericsに対して名前を登録出来ること
        $catType = CatType::factory()->create();
        $catCharacterics = CatCharacterics::factory()->create();

        $expectedName = 'テスト';

        $result = $this->useCase->execute(
            $expectedName,
            [
                $catType->key,
            ],
            [
                $catCharacterics->key,
            ]
        );

        $this->assertTrue($result->success);
        $this->assertDatabaseHas('name_ideas', [
            'name' => $expectedName,
        ]);
        $this->assertDatabaseHas('name_ideas_cat_types', [
            'cat_type_id' => $catType->id,
        ]);
        $this->assertDatabaseHas('name_ideas_cat_characterics', [
            'cat_characterics_id' => $catCharacterics->id,
        ]);
    }
}
