<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Name;

use App\Domain\CatCharacterics;
use App\Domain\CatType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmitNameActionTest extends TestCase
{
    use RefreshDatabase;

    public function test__登録成功()
    {
        $catType = CatType::factory()->create();
        $catCharacterics = CatCharacterics::factory()->create();

        $this->postJson('/api/names', [
            'name'       => 'test',
            'types'      => [
                $catType->key,
            ],
            'characters' => [
                $catCharacterics->key,
            ],
        ])
        ->assertStatus(200);
    }
}
