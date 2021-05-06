<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Cat;

use App\Domain\CatCharacterics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatCharactericsActionTest extends TestCase
{
    use RefreshDatabase;

    public function testInvoke__通常ケース()
    {
        CatCharacterics::factory()->count(3)->create();

        $expectedResponse = [];
        foreach (CatCharacterics::all() as $characterics) {
            $expectedResponse[] = [
                'id'   => $characterics->key,
                'name' => $characterics->name,
            ];
        }

        $this->get('/api/cat/characterics')
            ->assertJson($expectedResponse);
    }
}
