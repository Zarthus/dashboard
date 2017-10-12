<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-10
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Impl;

interface Container
{
    public function setRenderConfig(array $config);

    public function render(): string;

    public function getCacheTtl(): int;

    public function hashCode(): string;
}
