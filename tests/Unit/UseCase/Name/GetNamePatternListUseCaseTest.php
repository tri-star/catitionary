<?php

declare(strict_types=1);

namespace Tests\UseCase\Name;

use App\Domain\Name\NamePattern;
use App\UseCases\Name\GetNamePatternListUseCase;
use Tests\TestCase;

class GetNamePatternListUseCaseTest extends TestCase
{
    /** @var GetNamePatternListUseCase */
    private $useCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->useCase = new GetNamePatternListUseCase();
    }

    public function testExecute()
    {
        NamePattern::factory()->count(20)->create();

        $result = $this->useCase->execute(10);

        $this->assertTrue($result->success);
        $this->assertCount(10, $result->data['list']);

        $firstResultNames = collect($result->data['list'])->map(function ($item) {
            return $item->name;
        })->toArray();

        $result = $this->useCase->execute(10);
        $this->assertCount(10, $result->data['list']);
        $secondResultNames = collect($result->data['list'])->map(function ($item) {
            return $item->name;
        })->toArray();

        $this->assertNotEquals($firstResultNames, $secondResultNames);
    }
}
