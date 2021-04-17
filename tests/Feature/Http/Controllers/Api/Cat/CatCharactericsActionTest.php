<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Cat;

use Tests\TestCase;

class CatCharactericsActionTest extends TestCase
{
    public function testInvoke__通常ケース()
    {
        $this->get('/api/cat/characterics')
            ->assertJson([
                [
                    'id'   => 'long-hair',
                    'name' => '長毛',
                ],
                [
                    'id'   => 'massive',
                    'name' => 'どっしり',
                ],
                [
                    'id'   => 'kinked-tail',
                    'name' => 'カギしっぽ',
                ],
            ]);
    }
}
