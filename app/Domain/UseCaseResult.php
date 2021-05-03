<?php

declare(strict_types=1);

namespace App\Domain;

use Illuminate\Support\Arr;

/**
 * UseCaseの処理結果用のクラス。
 * 専用のフィールドを追加したい場合はこのクラスを継承したクラスを用意する
 */
class UseCaseResult
{
    /** @var bool 処理が成功したかどうか */
    public bool $success;

    /** @var array エラー情報 */
    public array $errors;

    /** @var array $data その他のデータ */
    public array $data;

    public function __construct(bool $success, array $data = [], ?array $errors=null)
    {
        $this->success = $success;
        $this->data = $data;
        $this->errors = $errors ?? [];
    }


    public function get(string $key, $default=null)
    {
        return Arr::get($this->data, $key, $default);
    }
}
