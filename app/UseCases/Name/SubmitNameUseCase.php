<?php

declare(strict_types=1);

namespace App\UseCases\Name;

use App\Domain\UseCaseResult;
use App\Validation\ValidationResult;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * 名前案を一括登録する
 */
class SubmitNameUseCase
{
    /**
     * @var array|null $nameIdeas
     */
    public function execute($nameIdeas)
    {
        if (!is_array($nameIdeas)) {
            return new UseCaseResult(
                false,
                [],
                new ValidationResult(false)
            );
        }

        $transactionResult = DB::transaction(function () use ($nameIdeas) {
            $subUseCase = new SubmitNameSubUseCase();
            foreach ($nameIdeas as $nameIdea) {
                $result = $subUseCase->execute(
                    Arr::get($nameIdea, 'name'),
                    Arr::get($nameIdea, 'types'),
                    Arr::get($nameIdea, 'characters')
                );
                if (!$result->success) {
                    return new UseCaseResult(
                        false,
                        [],
                        new ValidationResult(false)
                    );
                }
            }

            return new UseCaseResult(true);
        });

        return $transactionResult;
    }
}
