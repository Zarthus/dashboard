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

use Zarthus\Dashboard\Core\Cache\FilesystemCache;

class Kernel
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var FilesystemCache
     */
    private $cache;

    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $version;

    public function __construct(string $name = 'zarthus-dashboard', string $version = 'dev-master')
    {
        $this->name = $name;
        $this->version = $version;
    }

    public function boot(): void
    {
        $this->config = $this->loadConfig('main');
        ExceptionHandler::register($this->isDebug());

        $this->cache = FilesystemCache::fromApplication();

        if ($this->config->get('no_cache') ?? false) {
            // TODO: Write an adapter that doesn't cache to begin with.
            $this->cache->getPool()->clear();
        }
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

    /**
     * @return FilesystemCache
     */
    public function getCache(): FilesystemCache
    {
        return $this->cache;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
