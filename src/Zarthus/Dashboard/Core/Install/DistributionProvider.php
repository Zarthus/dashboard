<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Install;

use Zarthus\Dashboard\Core\Directory;

class DistributionProvider
{
    public static function copyConfig(): void
    {
        $base = Directory::ROOT;

        static::copyDist($base . '/.env');
        static::copyDist($base . '/config/main.php');
        static::copyDist($base . '/config/layout.php');
    }

    protected static function copyDist(string $name): void
    {
        $cleanName = preg_replace('@.*\.\./@', '', $name);
        echo "[Check] $cleanName" . PHP_EOL;

        if (!file_exists($name)) {
            echo "  [Copy] $cleanName.dist to $cleanName" . PHP_EOL;
            copy("$name.dist", $name);
        }
    }
}
