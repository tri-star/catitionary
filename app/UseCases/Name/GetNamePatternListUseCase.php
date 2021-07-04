<?php

declare(strict_types=1);

namespace App\UseCases\Name;

use App\Domain\Name\NamePattern;
use App\Domain\UseCaseResult;

class GetNamePatternListUseCase
{
    public function execute(int $count): UseCaseResult
    {
        $list = NamePattern::inRandomOrder()->limit($count)->get();

        return new UseCaseResult(true, [
            'list' => $list,
        ]);
    }
}
