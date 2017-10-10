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

use Symfony\Component\HttpFoundation\Response;
use Zarthus\Dashboard\Core\Impl\Container as ContainerImpl;
use Zarthus\Dashboard\Core\Module\ColumnCollection;

class Container implements ContainerImpl
{
    public function __construct()
    {

    }

    public function getColumns(): ColumnCollection
    {
        // TODO: Implement getColumns() method.
    }

    public function render(): Response
    {
        // TODO: Implement render() method.
    }
}
