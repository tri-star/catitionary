<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * 猫の種類
 */
class CatType
{
    /** @var string キジトラ */
    public const KIJITORA = 'kijitora';
    /** @var string キジシロ */
    public const KIJISHIRO = 'kijishiro';

    private const NAMES = [
        self::KIJITORA  => 'キジトラ',
        self::KIJISHIRO => 'キジシロ',
    ];

    /** @var string 種類 */
    private $type;

    public function __construct(string $type)
    {
        if (!self::isValid($type)) {
            throw new \RuntimeException("無効な種類が指定されました: {$type}");
        }
        $this->type = $type;
    }

    public function value()
    {
        return $this->type;
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
     * 種類のコード値の一覧を返す
     * @return string[]
     */
    public static function getTypes(): array
    {
        return array_keys(self::NAMES);
    }


    /**
     * 有効な値化を返す
     * @param string $type 種類のコード
     * @return bool
     */
    public static function isValid(string $type): bool
    {
        return in_array($type, self::getTypes(), true);
    }
}
