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

use Zarthus\Dashboard\Core\Ds\Collection;
use Zarthus\Dashboard\Core\Impl\Container;

class ContainerCollection extends Collection
{
    /**
     * @var Container[]
     */
    protected $data;

    /**
     * @param string $key
     *
     * @return Container
     */
    public function get($key): Container
    {
        return parent::get($key);
    }
}
