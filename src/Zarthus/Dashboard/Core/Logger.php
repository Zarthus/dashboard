<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-10
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;
use Psr\Log\LogLevel;

class Logger extends Monolog
{
    public static function new(string $name, bool $debug = false): Logger
    {
        return new self(
            $name,
            [
                new StreamHandler(
                    Directory::LOG . '/dash.log',
                    $debug ? LogLevel::DEBUG : LogLevel::INFO
                )
            ]
        );
    }
}
