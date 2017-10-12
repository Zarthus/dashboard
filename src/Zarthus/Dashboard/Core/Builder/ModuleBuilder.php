<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-10
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Builder;

use Zarthus\Dashboard\Core\Impl\Builder;
use Zarthus\Dashboard\Core\Impl\Module;
use Zarthus\Dashboard\Core\Kernel;

class ModuleBuilder implements Builder
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $namespace = '\\Zarthus\\Dashboard\\Modules\\';

    public static function builder(): self
    {
        return new self();
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function config(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function namespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function build(Kernel $kernel): Module
    {
        $moduleName = $this->namespace . str_replace(['.', '/'], '\\', $this->name);

        return new $moduleName($kernel, $this->name, $this->config);
    }
}
