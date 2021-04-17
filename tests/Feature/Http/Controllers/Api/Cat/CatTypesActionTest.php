<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Cat;

use Tests\TestCase;

class CatTypesActionTest extends TestCase
{
    public function testInvoke__通常ケース()
    {
        $this->get('/api/cat/types')
            ->assertJson([
                [
                    'id'   => 'kijitora',
                    'name' => 'キジトラ',
                ],
                [
                    'id'   => 'kijishiro',
                    'name' => 'キジシロ',
                ],
            ]);
    }
}
