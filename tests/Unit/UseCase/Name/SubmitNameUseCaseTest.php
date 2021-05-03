<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use App\UseCases\Name\SubmitNameUseCase;
use App\Validation\ValidationErrorItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
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

        $this->assertEquals($expectedError, $result->errors);
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
                    [
                        'field' => 'name',
                        'code'  => ValidationErrorItem::CODE_MISSING,
                    ],
                ],
            ],
            // 'cat_type' => [
            //     'parameter' => [
            //         'name'       => 'test',
            //         'characters' => ['hachiware'],
            //     ],
            //     'expected_message' => '',
            // ],
        ];
    }


    /**
     * @dataProvider forTest__登録失敗__不正なコード
     */
    public function test__登録失敗__不正なコード($parameters, $expectedError)
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

        $this->assertEquals($expectedError, $result->errors);
    }


    public function forTest__登録失敗__不正なコード()
    {
        return [
            'cat_type' => [
                'parameter' => [
                    'name'       => 'test',
                    'types'      => ['unknown'],
                    'characters' => ['hachiware'],
                ],
                'expected_errors' => '',
            ],
        ];
    }
}
