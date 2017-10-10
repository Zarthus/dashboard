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

use Psr\Log\LoggerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;
use Zarthus\Dashboard\Core\Exception\Fatal\ApplicationException;

class ExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public static function register(bool $debug): void
    {
        if ($debug) {
            $whoops = new Whoops();
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->register();
        } else {
            set_exception_handler([new self(), 'handleException']);
        }
    }

    public function handleException(\Throwable $throwable): void
    {
        if ($throwable instanceof ApplicationException) {
            $this->getLogger()->emergency(
                sprintf(
                    'Application Exception: %s: %s',
                    get_class($throwable),
                    $throwable->getMessage()
                ),
                ['exception' => $throwable]
            );
        } else {
            $this->getLogger()->error(
                sprintf(
                    'Uncaught Exception: %s: %s',
                    get_class($throwable),
                    $throwable->getMessage()
                ),
                ['exception' => $throwable]
            );
        }
    }

    private function getLogger(): LoggerInterface
    {
        if (!$this->logger) {
            $this->logger = new Logger('ExceptionHandler');
        }

        return $this->logger;
    }
}
