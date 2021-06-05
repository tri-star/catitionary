<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_登録を実行できること()
    {
        $user = [
            'email'    => 'test@example.com',
            'login_id' => 'test01',
            'password' => 'testtest',
        ];
        $this->postJson('/api/internal/auth/register', $user)
            ->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'login_id' => 'test01',
        ]);
    }
}
