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
}
