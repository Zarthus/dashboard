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

use Zarthus\Dashboard\Core\Directory;
use Zarthus\Dashboard\Core\Exception\Fatal\FileNotFoundException;
use Zarthus\Dashboard\Core\Exception\Fatal\InvalidConfigurationException;
use Zarthus\Dashboard\Core\Feature\KernelAware;
use Zarthus\Dashboard\Core\Feature\RendersTemplates;
use Zarthus\Dashboard\Core\Impl\Container as ContainerImpl;

class Container implements ContainerImpl
{
    use RendersTemplates;
    use KernelAware;

    /**
     * @var string
     */
    public $templateName;

    /**
     * @var array
     */
    public $render;

    /**
     * @var array
     */
    public $variables;

    public function __construct(string $templateName)
    {
        $this->setTemplateName($templateName);
    }

    public function render(): string
    {
        $output = [];

        foreach ($this->render as $sectionKey => $config) {
            $section = Section::fromConfig($this->kernel, $sectionKey, $config);

            $output[$sectionKey] = $section->getModule()->runExecute();
        }

        return $this->renderTemplate(
            'templates/' . $this->templateName,
            array_merge($this->getVariables(), $output)
        );
    }

    /**
     * @return array
     */
    public function getRender(): array
    {
        return $this->render;
    }

    /**
     * @param array $render
     *
     * @return self
     */
    public function setRenderConfig(array $render): Container
    {
        $this->render = $render;

        return $this;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @param array $variables
     *
     * @return self
     */
    public function setVariables(array $variables): Container
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     *
     * @return Container
     *
     * @throws FileNotFoundException
     * @throws InvalidConfigurationException
     */
    protected function setTemplateName(string $templateName): Container
    {
        if (strpos($templateName, '.') !== false) {
            throw new InvalidConfigurationException(sprintf(
                'Illegal template name \'%s\' : Cannot have dots in file name.',
                $templateName
            ));
        }

        if (!file_exists(Directory::join(Directory::TEMPLATES, $templateName . '.php'))) {
            throw new FileNotFoundException(sprintf(
                'Template %s not found in %s.',
                $templateName,
                Directory::TEMPLATES
            ));
        }
        $this->templateName = $templateName;

        return $this;
    }

    public function getCacheTtl(): int
    {
        return $this->render['cache_ttl'] ?? 300;
    }

    public function hashCode(): string
    {
        return hash('sha256', serialize($this->render));
    }
}
