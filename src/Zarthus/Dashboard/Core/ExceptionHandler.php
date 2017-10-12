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
use Whoops\Handler\Handler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;
use Zarthus\Dashboard\Core\Exception\Fatal\ApplicationException;

class ExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool
     */
    private $debug;

    public static function register(bool $debug): void
    {
        $whoops = new Whoops();
        $handler = new self($debug);

        if ($debug) {
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->pushHandler(function ($exception) use ($handler) {
                $handler->logException($exception);
            });
        } else {
            $whoops->pushHandler([$handler, 'handleException']);

            $whoops->pushHandler(function () {
                echo 'Something went wrong, sorry about that.';

                return Handler::QUIT;
            });

            ini_set('display_errors', false);
        }

        $whoops->register();
    }

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function handleException(\Throwable $throwable): void
    {
        $this->logException($throwable);
    }

    public function logException(\Throwable $throwable): void
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
            $this->logger = Logger::new('ExceptionHandler', $this->debug);
        }

        return $this->logger;
    }
}
