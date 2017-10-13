<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Terminal;

use Zarthus\Dashboard\Core\Directory;

class CommandProvider
{
    public static function clearCache(): void
    {
        $base = Directory::CACHE;

        static::clearCacheDirectory($base . '/dash');
    }

    protected static function clearCacheDirectory(string $name): void
    {
        $cleanName = preg_replace('@.*\.\./@', '', $name);
        echo "[Check] $cleanName" . PHP_EOL;

        if (is_dir($name)) {
            echo "  [Removing Directory] $cleanName" . PHP_EOL;

            foreach (glob($name . '/*') as $file) {
                $cleanFileName = preg_replace('@.*\.\./@', '', $file);

                if (strlen($file) === strlen($name) + 1 + 64) {
                    echo "    [Removing File] $cleanFileName" . PHP_EOL;
                    unlink($file);
                }
            }
            rmdir($name);
            echo "  [Directory Removed] $cleanName" . PHP_EOL;
        }
    }
}
