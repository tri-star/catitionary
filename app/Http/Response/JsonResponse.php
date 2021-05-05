<?php

declare(strict_types=1);

namespace App\Http\Response;

use Illuminate\Http\JsonResponse as BaseJsonResponse;

/**
 * プロジェクトのデフォルトのJsonResponse
 * ユニコードをエスケープしない
 */
class JsonResponse extends BaseJsonResponse
{
    public function __construct($data = null, $status = 200, $headers = [], $options = JSON_UNESCAPED_UNICODE)
    {
        parent::__construct($data, $status, $headers, $options);
    }


    /**
     * エラー情報をAPIレスポンス用に整形して返す
     */
    public static function formatError(array $errors): array
    {
        $results = [];

        foreach ($errors as $fieldName=>$errorCodes) {
            foreach ($errorCodes as $errorCode) {
                $results[] = [
                    'field' => $fieldName,
                    'code'  => $errorCode,
                ];
            }
        }
        return $results;
    }
}
