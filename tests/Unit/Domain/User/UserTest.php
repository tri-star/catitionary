<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
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


    /**
     * @dataProvider forTest__メール確認コード__有効期限
     */
    public function test__メール確認コード__有効期限($userCreatedAt, $now, $expectOk)
    {
        Carbon::setTestNow($now);
        $baseUser = User::factory()->create([
            'created_at' => $userCreatedAt,
        ]);

        $user = User::byEmailVerificationCode($baseUser->email_verification_code)->first();

        if ($expectOk) {
            $this->assertNotNull($user);
        } else {
            $this->assertNull($user);
        }
    }


    public function forTest__メール確認コード__有効期限()
    {
        return [
            '有効期限内__確認OK' => [
                'user_created' => '2021-01-01 10:00:00',
                'now'          => '2021-01-01 10:00:00',
                'expectOk'     => true,
            ],
            '有効期限ちょうど__確認OK' => [
                'user_created' => '2021-01-01 10:00:00',
                'now'          => '2021-01-02 10:00:00',
                'expectOk'     => true,
            ],
            '有効期限切れ__確認NG' => [
                'user_created' => '2021-01-01 10:00:00',
                'now'          => '2021-01-02 10:00:01',
                'expectOk'     => false,
            ],
        ];
    }
}
