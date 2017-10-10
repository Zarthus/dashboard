<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-10
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Module;

use Zarthus\Dashboard\Core\Ds\Collection;
use Zarthus\Dashboard\Core\Impl\Module;

class ModuleCollection extends Collection
{
    /**
     * @var Module[]
     */
    protected $data;

    /**
     * @param Module[] $containers
     */
    public function __construct(array $containers)
    {
        parent::__construct($containers);
    }

    /**
     * @param string $key
     *
     * @return Module
     */
    public function get($key): Module
    {
        return parent::get($key);
    }
}
