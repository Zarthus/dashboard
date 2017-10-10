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

class Kernel
{
    /**
     * @var Config
     */
    private $config;

    public function boot(): void
    {
        $this->config = $this->loadConfig('main');

        ExceptionHandler::register($this->isDebug());
    }

    public function loadConfig(string $name): Config
    {
        return new Config($name);
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function isDebug(): bool
    {
        return (bool) $this->config->get('debug');
    }
}
