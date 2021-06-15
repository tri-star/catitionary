<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\User;

use App\Domain\User\User;
use App\UseCases\User\VerifyEmailUseCase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class VerifyEmailUseCaseTest extends TestCase
{
    /** @var VerifyEmailUseCase */
    private $useCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->useCase = App::make(VerifyEmailUseCase::class);
    }


    public function test_execute()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $result = $this->useCase->execute($user->email_verification_code);

        $user->refresh();
        $this->assertTrue($result->success);
        $this->assertNotNull($user->email_verified_at);
    }
}
