<?php

declare(strict_types=1);

namespace App\Validation;

use Illuminate\Support\Facades\App;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

class ValidationResult
{
    /**
     * バリデーションが成功したか
     * @var bool
     */
    private bool $passed;

    /**
     * Laravelのバリデーションエラー情報を含んだ配列
     * @var array
     */
    private array $laravelValidationErrors;

    /**
     * Laravelのエラーメッセージ情報
     * @var MessageBag
     */
    private MessageBag $laravelErrorMessages;

    public function __construct(bool $passed, ?array $laravelValidationErrors=null, ?MessageBag $laravelErrorMessages=null)
    {
        $this->passed = $passed;
        $this->laravelValidationErrors = $laravelValidationErrors ?? [];
        $this->laravelErrorMessages = $laravelErrorMessages ?? new MessageBag();
    }


    public static function fromValidator(Validator $validator): self
    {
        return new self(
            $validator->messages()->isEmpty(),
            $validator->failed(),
            $validator->errors()
        );
    }

    public function passed(): bool
    {
        return $this->passed;
    }

    /**
     * アプリケーション用のエラー情報を含んだ配列
     * @return array
     *
     * [
     *     'field_name' => [
     *         ValidationErrorItem::CODE_MISSING,
     *     ],
     * ]
     */
    public function getErrors(): array
    {
        $converter = new ValidationErrorConverter();
        return $converter->convert($this->laravelValidationErrors, [], ValidationErrorItem::CODE_GENERAL);
    }
}
