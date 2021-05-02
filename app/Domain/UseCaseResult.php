<?php

declare(strict_types=1);

namespace App\Domain;

use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;

/**
 * UseCaseの処理結果用のクラス。
 * 専用のフィールドを追加したい場合はこのクラスを継承したクラスを用意する
 */
class UseCaseResult
{
    /** @var bool 処理が成功したかどうか */
    public bool $success;

    /** @var MessageBag エラーメッセージ */
    public MessageBag $errors;

    /** @var array $data その他のデータ */
    public array $data;

    public function __construct(bool $success, array $data = [], ?MessageBag $errors=null)
    {
        $this->success = $success;
        $this->data = $data;
        $this->errors = $errors ?? new MessageBag();
    }


    public function get(string $key, $default=null)
    {
        return Arr::get($this->data, $key, $default);
    }
}
