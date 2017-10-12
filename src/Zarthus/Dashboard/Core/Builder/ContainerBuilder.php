<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Builder;

use Zarthus\Dashboard\Core\Exception\Fatal\ApplicationException;
use Zarthus\Dashboard\Core\Html\Container;
use Zarthus\Dashboard\Core\Html\ContainerCollection;
use Zarthus\Dashboard\Core\Kernel;

class ContainerBuilder
{
    /**
     * @var ContainerCollection
     */
    private $collection;

    /**
     * @var Container
     */
    private $currentContainer;

    public static function fromConfig(Kernel $kernel, array $config): ContainerBuilder
    {
        $builder = new self();

        foreach ($config as $container) {
            $builder->newContainer($kernel, $container['template'])
                ->render($container['render'])
                ->append();
        }

        return $builder;
    }

    public function __construct()
    {
        $this->collection = new ContainerCollection();
    }

    public function newContainer(Kernel $kernel, string $templateName): self
    {
        $this->currentContainer = new Container($templateName);
        $this->currentContainer->setKernel($kernel);

        return $this;
    }

    public function render(array $render): self
    {
        $this->currentContainer->setRenderConfig($render);

        return $this;
    }

    /**
     * @return ContainerBuilder
     *
     * @throws \Zarthus\Dashboard\Core\Exception\Fatal\ApplicationException
     */
    public function append(): self
    {
        if ($this->currentContainer === null) {
            throw new ApplicationException('Cannot append container when $currentContainer is null.');
        }

        $this->collection->add($this->currentContainer);

        $this->currentContainer = null;

        return $this;
    }

    public function getCollection(): ContainerCollection
    {
        return $this->collection;
    }
}
