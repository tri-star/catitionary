<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Internal\User;

use App\Domain\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExistActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログインID__登録済の場合trueを返す()
    {
        $user = User::factory()->create();
        $loginId = $user->login_id;

        $this->get("/api/internal/user/exists?login_id={$loginId}", )
            ->assertStatus(200)
            ->assertExactJson([
                'exist' => true,
            ]);
    }
}
