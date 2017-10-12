<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-09
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core;

final class Directory
{
    public const ROOT = __DIR__ . '/../../../..';

    public const CONFIG = self::ROOT . '/config';

    public const TEMP = self::ROOT . '/var';
    public const CACHE = self::TEMP . '/cache';
    public const LOG = self::TEMP . '/logs/dash';

    public const RESOURCES = __DIR__ . '/Resources';
    public const VIEWS = self::RESOURCES . '/view';
    public const TEMPLATES = self::VIEWS . '/templates';

    public static function join(string ...$path): string
    {
        $joined = '';

        foreach ($path as $p) {
            $joined .= rtrim($p, '/\\') . DIRECTORY_SEPARATOR;
        }

        return rtrim($joined, '/\\');
    }
}
