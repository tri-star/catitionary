<?php

declare(strict_types=1);

namespace App\Validation;

/**
 * LaravelのValidatorが返すエラー情報を
 * アプリケーション用のエラー情報の構造に変換する
 */
class ValidationErrorConverter
{
    /**
     * Laravelのバリデーションのルール名をシステムのタイプ名に変換するための配列
     * @var array
     */
    private $baseTypeMap = [
        'Required' => 'missing',
    ];


    /**
     * 変換を実行する
     * @var array $laravelValidationResult LaravelのValidator::failedが返す配列
     * @var array $customTypeMap LaravelのValidatorのルール名(required等)に対応するシステム内のルール名
     * @var string $fallbackName $typeMapに一致しなかった場合に使用するシステム内のルール名
     * @return array 変換後の配列
     */
    public function convert(array $laravelValidationResult, array $customTypeMap, string $fallbackName): array
    {
        $result = [];
        $typeMap = array_merge($this->baseTypeMap, $customTypeMap);
        foreach ($laravelValidationResult as $field => $rules) {
            foreach ($rules as $ruleName=>$unused) {
                if (!isset($result[$field])) {
                    $result[$field] = [];
                }
                $result[$field][] = $typeMap[$ruleName] ?? $fallbackName;
            }
        }
        return $result;
    }
}
