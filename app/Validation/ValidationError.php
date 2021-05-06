<?php

declare(strict_types=1);

namespace App\Domain\Validation;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;

class ValidationError
{
    /**
     * エラーメッセージ
     * @var MessageBag
     */
    private $messages;

    /**
     * Validator::failed()が返すエラー情報
     * @var array
     *
     * [
     *     'name' => [
     *         'Required' => []
     *     ]
     * ]
     */
    private $errors;

    public function __construct(MessageBag $messages, array $errors)
    {
        $this->messages = $messages;
        $this->errors = $errors;
    }


    public static function fromLaravelValidator(Validator $validator): self
    {
        if (!$validator->failed()) {
            throw new \RuntimeException('バリデーションが実行されていません');
        }
        return new self($validator->errors(), $validator->failed());
    }


    public function getMessages(): MessageBag
    {
        return $this->messages;
    }


    public function getErrors(): array
    {
        return $this->errors;
    }
}
