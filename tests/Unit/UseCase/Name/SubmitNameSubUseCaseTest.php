<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use App\Domain\Name\NameIdea;
use App\UseCases\Name\SubmitNameSubUseCase;
use App\Validation\ValidationErrorItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class SubmitNameSubUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @var SubmitNameSubUseCase $useCase  */
    private $useCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->useCase = new SubmitNameSubUseCase();
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


    /**
     * @dataProvider forTest__登録失敗__必須パラメータ不足
     */
    public function test__登録失敗__必須パラメータ不足($parameters, $expectedError)
    {
        CatType::factory()->create([
            'key' => 'kijitora',
        ]);
        CatCharacterics::factory()->create([
            'key' => 'hachiware',
        ]);

        $result = $this->useCase->execute(
            Arr::get($parameters, 'name'),
            Arr::get($parameters, 'types'),
            Arr::get($parameters, 'characters'),
        );

        $this->assertEquals($expectedError, $result->validationResult->getErrors());
    }


    public function forTest__登録失敗__必須パラメータ不足()
    {
        return [
            'name' => [
                'parameter' => [
                    'types'      => ['kijitora'],
                    'characters' => ['hachiware'],
                ],
                'expected_errors' => [
                    'name' => [ValidationErrorItem::CODE_MISSING],
                ],
            ],
        ];
    }


    /**
     * @dataProvider forTest__登録失敗__各種エラー
     */
    public function test__登録失敗__各種エラー($parameters, $expectedError)
    {
        $catType = CatType::factory()->create([
            'key' => 'kijitora',
        ]);
        CatCharacterics::factory()->create([
            'key' => 'hachiware',
        ]);
        $result = $this->useCase->execute(
            Arr::get($parameters, 'name'),
            Arr::get($parameters, 'types'),
            Arr::get($parameters, 'characters'),
        );

        $this->assertEquals($expectedError, $result->validationResult->getErrors());
    }


    public function forTest__登録失敗__各種エラー()
    {
        return [
            'name__最大文字数超過' => [
                'parameter' => [
                    'name'       => str_repeat('a', NameIdea::NAME_MAX_LENGTH + 1),
                    'types'      => ['kijitora'],
                    'characters' => ['hachiware'],
                ],
                'expected_errors' => [
                    'name'  => [ValidationErrorItem::CODE_OUT_OF_RANGE,],
                ],
            ],
            'name__0文字' => [
                'parameter' => [
                    'name'       => '',
                    'types'      => ['kijitora'],
                    'characters' => ['hachiware'],
                ],
                'expected_errors' => [
                    'name'  => [ValidationErrorItem::CODE_MISSING,],
                ],
            ],
            'cat_type__不正なコード' => [
                'parameter' => [
                    'name'       => 'test',
                    'types'      => ['unknown'],
                    'characters' => ['hachiware'],
                ],
                'expected_errors' => [
                    'types'  => [ValidationErrorItem::CODE_INVALID,],
                ],
            ],
            'cat_type__配列以外' => [
                'parameter' => [
                    'name'       => 'test',
                    'types'      => 'string_value',
                    'characters' => ['hachiware'],
                ],
                'expected_errors' => [
                    'types'  => [ValidationErrorItem::CODE_INVALID,],
                ],
            ],
        ];
    }
}
