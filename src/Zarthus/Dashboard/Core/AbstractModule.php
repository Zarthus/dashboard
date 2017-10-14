<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core;

use Zarthus\Dashboard\Core\Exception\Module\ValidationException;
use Zarthus\Dashboard\Core\Impl\Module;

abstract class AbstractModule implements Module
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var array
     */
    protected $config;
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Kernel
     */
    protected $kernel;

    public function __construct(Kernel $kernel, string $name, array $config)
    {
        $this->name = $name;
        $this->config = $config;
        $this->kernel = $kernel;

        $this->validate();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function validate(): void;

    /**
     * Normalizes the configuration, setting optional configuration
     * values to their appropriate default value, casting the right type, etc.
     *
     * @return void
     */
    public function normalizeConfig(): void
    {
    }

    public function runExecute(): string
    {
        $this->normalizeConfig();

        $cachePool = $this->kernel->getCache()->getPool();
        $hashCode = $this->hashCode();

        if ($cachePool->has($hashCode)) {
            return (string) $cachePool->get($hashCode);
        }

        $exec = $this->execute();

        $cachePool->set($hashCode, $exec, $this->getCacheTtl());

        return $exec;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function execute(): string;

    public function getName(): string
    {
        return $this->name;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getLogger(): Logger
    {
        if (!$this->logger) {
            $this->logger = Logger::new($this->getName(), $this->kernel->isDebug());
        }

        return $this->logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheTtl(): int
    {
        return $this->config['cache_ttl'] ?? $this->getDefaultCacheTtl();
    }

    /**
     * {@see AbstractModule#getCacheTtl}
     *
     * @return int
     */
    abstract public function getDefaultCacheTtl(): int;

    /**
     * @param string $key
     *
     * @throws ValidationException if $key is not set in $this->config
     */
    protected function requireConfigOption(string $key): void
    {
        if (!isset($this->config[$key])) {
            throw new ValidationException(sprintf(
                'Required configuration option "%s" is not set.',
                $key
            ));
        }
    }

    public function hashCode(): string
    {
        return hash('sha256', $this->getName() . serialize($this->config));
    }
}
