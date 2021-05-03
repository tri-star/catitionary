<?php

declare(strict_types=1);

namespace App\Validation;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Validation\Validator;

class CatitionaryValidator extends Validator
{
    /**
     * カスタムのタイプマッピング
     * @var array
     */
    private $customTypeMap;

    public function __construct(Translator $translator, array $data, array $rules, array $messages, array $attributes=[])
    {
        parent::__construct($translator, $data, $rules, $messages, $attributes);
        $this->customTypeMap = [];
    }


    public function addCustomTypeMap(array $customTypeMap)
    {
        $this->customTypeMap = [...$this->customTypeMap, ...$customTypeMap];
    }


    public function getErrorFields()
    {
    }
}
