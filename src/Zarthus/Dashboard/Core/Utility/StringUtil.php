<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-14
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Utility;

final class StringUtil
{
    public static function truncate(string $string, int $limit = 255, $append = '..'): string
    {
        $length = strlen($string);

        if ($length < $limit) {
            return $string;
        }

        return substr($string, 0, $limit - strlen($append)) . $append;
    }
}
