<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Modules;

use Zarthus\Dashboard\Core\AbstractModule;

/**
 * No operation module. For when utilizing a preset that doesn't need a module, and mostly
 * consists of static HTML, or when you just want to completely delete a particular section.
 */
class NoOp extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    public function validate(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCacheTtl(): int
    {
        return 604800;
    }
}
