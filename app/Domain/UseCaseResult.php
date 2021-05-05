<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Validation\ValidationError;
use App\Validation\ValidationResult;
use Illuminate\Support\Arr;

/**
 * UseCaseの処理結果用のクラス。
 * 専用のフィールドを追加したい場合はこのクラスを継承したクラスを用意する
 */
class UseCaseResult
{
    /** @var bool 処理が成功したかどうか */
    public bool $success;

    /** @var ValidationResult バリデーションの結果情報 */
    public ValidationResult $validationResult;

    /** @var array $data その他のデータ */
    public array $data;

    public function __construct(bool $success, array $data = [], ?ValidationResult $validationResult=null)
    {
        $this->success = $success;
        $this->data = $data;
        $this->validationResult = $validationResult ?? new ValidationResult(true, []);
    }


    public function get(string $key, $default=null)
    {
        return Arr::get($this->data, $key, $default);
    }
}
