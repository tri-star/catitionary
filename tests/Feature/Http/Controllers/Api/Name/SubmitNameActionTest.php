<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Name;

use App\Domain\Name\NameIdea;
use Tests\TestCase;

class SubmitNameActionTest extends TestCase
{
    public function test通常ケース()
    {
        NameIdea::factory()->make();

        // $expectedResponse = [];
        // foreach (CatCharacterics::all() as $characterics) {
        //     $expectedResponse[] = [
        //         'id'   => $characterics->id,
        //         'name' => $characterics->name,
        //     ];
        // }

        // $this->get('/api/cat/characterics')
        //     ->assertJson($expectedResponse);
    }
}
