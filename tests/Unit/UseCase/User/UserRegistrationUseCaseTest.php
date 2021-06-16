<?php

namespace Tests\Unit\Domain\User;

use App\Domain\User\User;
use App\Notifications\EmailVerification;
use App\UseCases\User\UserRegistrationUseCase;
use App\Validation\ValidationErrorItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserRegistrationUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @var UserRegistrationUseCase */
    private $useCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->useCase = App::make(UserRegistrationUseCase::class);
    }


    public function test__通常ケース()
    {
        Notification::fake();

        $user = User::factory()->make();
        $data = [
            'email'    => $user->email,
            'login_id' => $user->login_id,
            'password' => $user->password,
        ];

        $this->useCase->execute($data);

        $this->assertDatabaseHas('users', [
            'login_id' => $user->login_id,
        ]);

        $registeredUser = User::byLoginId($user->login_id)->first();
        Notification::assertSentTo($registeredUser, EmailVerification::class);
    }


    /**
     * @dataProvider forTest__バリデーションエラー
     */
    public function test__バリデーションエラー($attributeClosure, $expectedErrors)
    {
        $attributes = $attributeClosure();

        $result = $this->useCase->execute($attributes);

        $errors = $result->validationResult->getErrors();

        $this->assertEquals($expectedErrors, $errors);
        $this->assertFalse($result->success);
    }


    public function forTest__バリデーションエラー()
    {
        return [
            'email__未入力' => [
                'attributeClosure' => function () {
                    return $this->getUserAttributes([], ['email']);
                },
                'expectedErrors' => [
                    'email' => [ ValidationErrorItem::CODE_MISSING ],
                ],
            ],
            'email__最大長超過' => [
                'attributeClosure' => function () {
                    return $this->getUserAttributes([
                        'email' => str_repeat('a', User::MAX_EMAIL_LENGTH + 1),
                    ]);
                },
                'expectedErrors' => [
                    'email' => [ ValidationErrorItem::CODE_OUT_OF_RANGE ],
                ],
            ],
            'email__重複' => [
                'attributeClosure' => function () {
                    $user = User::factory()->create();
                    return $this->getUserAttributes([
                        'email' => $user->email,
                    ]);
                },
                'expectedErrors' => [
                    'email' => [ ValidationErrorItem::CODE_DUPLICATE ],
                ],
            ],
            'loginId__未入力' => [
                'attributeClosure' => function () {
                    return $this->getUserAttributes([], ['login_id']);
                },
                'expectedErrors' => [
                    'login_id' => [ ValidationErrorItem::CODE_MISSING ],
                ],
            ],
            'loginId__最大長超過' => [
                'attributeClosure' => function () {
                    return $this->getUserAttributes([
                        'login_id' => str_repeat('a', User::MAX_LOGIN_ID_LENGTH + 1),
                    ]);
                },
                'expectedErrors' => [
                    'login_id' => [ ValidationErrorItem::CODE_OUT_OF_RANGE ],
                ],
            ],
            'loginId__重複' => [
                'attributeClosure' => function () {
                    $user = User::factory()->create();
                    return $this->getUserAttributes([
                        'login_id' => $user->login_id,
                    ]);
                },
                'expectedErrors' => [
                    'login_id' => [ ValidationErrorItem::CODE_DUPLICATE ],
                ],
            ],
            'password__未入力' => [
                'attributeClosure' => function () {
                    return $this->getUserAttributes([], ['password']);
                },
                'expectedErrors' => [
                    'password' => [ ValidationErrorItem::CODE_MISSING ],
                ],
            ],
        ];
    }


    private function getUserAttributes(array $customAttributes, array $excludeKeys=[])
    {
        $user = User::factory()->make($customAttributes);

        $attributes = [
            'email'    => $user->email,
            'login_id' => $user->login_id,
            'password' => $user->password,
        ];

        Arr::forget($attributes, $excludeKeys);

        return $attributes;
    }
}
