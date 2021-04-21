<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Cat;

use App\Domain\CatType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatTypesActionTest extends TestCase
{
    use RefreshDatabase;

    public function testInvoke__通常ケース()
    {
        CatType::factory()->count(3)->create();
        $catTypes = CatType::all();

        $expectedResponse = [];
        foreach ($catTypes as $catType) {
            $expectedResponse[] = [
                'id'   => $catType->id,
                'name' => $catType->name,
            ];
        }

        $this->get('/api/cat/types')
            ->assertJson($expectedResponse);
    }
}
