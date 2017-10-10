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

use Symfony\Component\HttpFoundation\Response;

interface Column
{
    public function size(): string;

    public function render(): Response;
}
