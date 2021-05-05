<?php

declare(strict_types=1);

namespace Tests\Validation;

use App\Validation\ValidationErrorConverter;
use App\Validation\ValidationErrorItem;
use Tests\TestCase;

class ValidationErrorConverterTest extends TestCase
{
    /**
     * @var ValidationErrorConverter
     */
    private $converter;


    public function setUp(): void
    {
        parent::setUp();
        $this->converter = new ValidationErrorConverter();
    }

    /**
     * @dataProvider forTest__Laravel標準のルール名が変換できること
     */
    public function test__Laravel標準のルール名が変換できること($input, $expected)
    {
        $result = $this->converter->convert($input, [], 'fallback');
        $this->assertEquals($expected, $result);
    }

    public function forTest__Laravel標準のルール名が変換できること()
    {
        return [
            'required' => [
                'input' => [
                    'name' => [
                        'Required' => [],
                    ],
                ],
                'expected' => [
                    'name' => [
                        ValidationErrorItem::CODE_MISSING,
                    ],
                ],
            ],
        ];
    }


    public function test__未定義のルール名はfallbackで指定した名前に変換されること()
    {
        $input = [
            'name' => [
                'Unknown' => [],
            ],
        ];

        $fallbackRuleName = 'fallbackRuleName';
        $expected = [
            'name' => [
                $fallbackRuleName,
            ],
        ];

        $result = $this->converter->convert($input, [], $fallbackRuleName);
        $this->assertEquals($expected, $result);
    }
}
