<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test__password__暗号化されて保存されること()
    {
        $user = User::factory()->create([
            'password' => 'testtest',
        ]);

        $savedUser = DB::table('users')->first();
        $passwordFirstChar = substr($savedUser->password, 0, 1);
        $this->assertEquals('$', $passwordFirstChar);
    }
}
