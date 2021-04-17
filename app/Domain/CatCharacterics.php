<?php

declare(strict_characterics=1);

namespace App\Domain;

/**
 * 猫の特徴
 */
class CatCharacterics
{
    /** @var string 長毛 */
    public const LONG_HAIR = 'long-hair';

    /** @var string どっしり */
    public const MASSIVE = 'massive';

    /** @var string カギしっぽ */
    public const KINKED_TAIL = 'kinked-tail';

    private const NAMES = [
        self::LONG_HAIR   => '長毛',
        self::MASSIVE     => 'どっしり',
        self::KINKED_TAIL => 'カギしっぽ',
    ];

    /** @var string 特徴 */
    private $characterics;

    public function __construct(string $characterics)
    {
        if (!self::isValid($characterics)) {
            throw new \RuntimeException("無効な特徴が指定されました: {$characterics}");
        }
        $this->characterics = $characterics;
    }

    public function value()
    {
        return $this->characterics;
    }


    /**
     * 名前のリストを返す
     * @return string[]
     */
    public static function getList(): array
    {
        return self::NAMES;
    }

    /**
     * 特徴のコード値の一覧を返す
     * @return string[]
     */
    public static function getCharacterics(): array
    {
        return array_keys(self::NAMES);
    }


    /**
     * 有効な値化を返す
     * @param string $characterics 種類のコード
     * @return bool
     */
    public static function isValid(string $characterics): bool
    {
        return in_array($characterics, self::getcharacterics(), true);
    }
}
