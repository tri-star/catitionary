<?php

namespace Tests\Unit\Domain\User;

use App\UseCases\User\UserRegistrationUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
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
        $data = [
            'email'    => 'test@example.com',
            'login_id' => 'test01',
            'password' => 'testtest',
        ];

        $this->useCase->execute($data);

        $this->assertDatabaseHas('users', [
            'login_id' => 'test01',
        ]);
    }
}
