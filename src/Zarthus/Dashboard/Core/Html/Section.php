<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Html;

use Zarthus\Dashboard\Core\Builder\ModuleBuilder;
use Zarthus\Dashboard\Core\Impl\Module;
use Zarthus\Dashboard\Core\Impl\Section as SectionImpl;
use Zarthus\Dashboard\Core\Kernel;

class Section implements SectionImpl
{
    public static function fromConfig(Kernel $kernel, string $key, ?array $config): Section
    {
        return new self($kernel, $key, $config['module'], $config['config'] ?? []);
    }

    /**
     * @var string
     */
    public $name;
    /**
     * @var Module
     */
    public $module;

    public function __construct(Kernel $kernel, string $sectionName, string $moduleName, array $config)
    {
        $this->name = $sectionName;

        $this->module = ModuleBuilder::builder()
            ->name($moduleName)
            ->config($config)
            ->build($kernel);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModule(): Module
    {
        return $this->module;
    }
}
