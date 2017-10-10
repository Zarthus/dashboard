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
use Zarthus\Dashboard\Core\Impl\Column;

class ColumnCollection extends Collection
{
    /**
     * @var Column[]
     */
    protected $data;

    /**
     * @param Column[] $containers
     */
    public function __construct(array $containers)
    {
        parent::__construct($containers);
    }

    /**
     * @param string $key
     *
     * @return Column
     */
    public function get($key): Column
    {
        return parent::get($key);
    }
}
