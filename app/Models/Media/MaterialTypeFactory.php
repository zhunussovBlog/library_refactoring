<?php


namespace App\Models\Media;

use App\Common\Interfaces\Query\DefaultQueryInterface;

/**
 * Class MaterialTypeFactory
 */
final class MaterialTypeFactory
{
    public const TYPES_BOOK = ['BK', 'VM', 'MX'];
    public const TYPES_DISC = ['CF', 'MP', 'MU'];
    public const TYPES_JOURNAL = ['CR'];

    /**
     * @param string $typeKey
     * @return DefaultQueryInterface
     */
    public static function getMaterialClass(string $typeKey): DefaultQueryInterface
    {
        if (in_array($typeKey, self::TYPES_BOOK)) {
            return new Book();
        }

        if (in_array($typeKey, self::TYPES_DISC)) {
            return new Disc();
        }

        if (in_array($typeKey, self::TYPES_JOURNAL)) {
            return new Journal();
        }
    }
}
