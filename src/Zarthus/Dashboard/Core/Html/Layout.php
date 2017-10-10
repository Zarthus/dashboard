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

use League\Plates\Engine as TemplateEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zarthus\Dashboard\Core\Builder\ModuleBuilder;
use Zarthus\Dashboard\Core\Config;
use Zarthus\Dashboard\Core\Directory;
use Zarthus\Dashboard\Core\Ds\Collection;
use Zarthus\Dashboard\Core\Exception\Fatal\InvalidConfigurationException;
use Zarthus\Dashboard\Core\Kernel;
use Zarthus\Dashboard\Core\Module\ColumnCollection;
use Zarthus\Dashboard\Core\Module\ContainerCollection;

class Layout
{
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

        if (!$this->config->hasKey('layout:' . $this->layoutName)) {
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
        $templates = new TemplateEngine(Directory::VIEWS);
        $html = $templates->render('layout/base', [
            'title' => $this->getLayoutConfig()['title'],
            'layout' => $this->getLayoutConfig()['variables'],
        ]);

        // TODO
        $html = str_replace('{{ contents }}', '{{ contents }}', $html);

        return new Response($html);
//        $this->buildModules(
//            new ModuleCollection($this->getConfig()->get('modules'))
//        );
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

    private function buildModules(Collection $modules): ContainerCollection
    {

    }

    private function buildModule(ModuleBuilder $builder): ColumnCollection
    {

    }
}
