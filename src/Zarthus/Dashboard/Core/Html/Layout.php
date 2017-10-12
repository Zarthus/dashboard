<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-10
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Html;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zarthus\Dashboard\Core\Builder\ContainerBuilder;
use Zarthus\Dashboard\Core\Config;
use Zarthus\Dashboard\Core\Exception\Fatal\InvalidConfigurationException;
use Zarthus\Dashboard\Core\Feature\RendersTemplates;
use Zarthus\Dashboard\Core\Kernel;

class Layout
{
    use RendersTemplates;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $layoutName;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Kernel
     */
    private $kernel;

    public function __construct(Kernel $kernel, Request $request, string $layoutName)
    {
        $this->layoutName = strtolower($layoutName);
        $this->config = new Config('layout');

        if (!$this->config->exists('layout:' . $this->layoutName)) {
            throw new InvalidConfigurationException(sprintf(
                'Layout %s does not exist in config:layout',
                $this->layoutName
            ));
        }

        $this->request = $request;
        $this->kernel = $kernel;
    }

    public function render(): Response
    {
        $containers = ContainerBuilder::fromConfig($this->kernel, $this->getLayoutConfig()['containers'])
            ->getCollection();

        $html = $this->renderTemplate('layout/base', [
            'title' => $this->getLayoutConfig()['title'] ?? 'Unknown Dashboard',
            'layout' => $this->getLayoutConfig()['variables'],
            'contents' => $this->renderContainers($containers)
        ]);

        return new Response($html);
    }

    protected function renderContainers(ContainerCollection $collection): string
    {
        $output = '';

        $cachePool = $this->kernel->getCache()->getPool();

        /**
         * @var $container Container
         */
        foreach ($collection as $container) {
            $hashCode = $container->hashCode();

            if ($cachePool->has($hashCode)) {
                $output .= $cachePool->get($hashCode);
            } else {
                $render = $container->render();

                $output .= $render . PHP_EOL;

                $cachePool->set($hashCode, $render, $container->getCacheTtl());
            }
        }

        return $output;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getLayoutConfig(): array
    {
        return $this->config->get('layout:' . $this->layoutName);
    }

    /**
     * @return string
     */
    public function getLayoutName(): string
    {
        return $this->layoutName;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
