<?php

declare(strict_types=1);

namespace App\Validation;

use App\Rule\Cat\CatCharactericsRule;
use App\Rule\Cat\CatTypeRule;

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
        'Array'                    => ValidationErrorItem::CODE_INVALID,
        'Max'                      => ValidationErrorItem::CODE_OUT_OF_RANGE,
        'Required'                 => ValidationErrorItem::CODE_MISSING,
        'Max'                      => ValidationErrorItem::CODE_INVALID,
        'Min'                      => ValidationErrorItem::CODE_INVALID,
        CatTypeRule::class         => ValidationErrorItem::CODE_INVALID,
        CatCharactericsRule::class => ValidationErrorItem::CODE_INVALID,
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
            $result[$field] = array_unique($result[$field]);
        }
        return $result;
    }
}
