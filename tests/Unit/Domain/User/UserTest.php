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


    /**
     * @dataProvider forTest__最大長を保存出来ること
     */
    public function test__最大長を保存出来ること($attributes)
    {
        $user = User::factory()->create($attributes);

        $savedUser = User::byLoginId($user['login_id']);
        $this->assertNotNull($savedUser);
    }


    public function forTest__最大長を保存出来ること()
    {
        return [
            'email' => [
                'attributes' => [
                    'email' => str_repeat('A', User::MAX_EMAIL_LENGTH),
                ],
            ],
            'login_id' => [
                'attributes' => [
                    'login_id' => str_repeat('A', User::MAX_LOGIN_ID_LENGTH),
                ],
            ],
            'password' => [
                'attributes' => [
                    'password' => str_repeat('A', User::MAX_PASSWORD_LENGTH),
                ],
            ],
        ];
    }
}
