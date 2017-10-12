<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Feature;

use Zarthus\Dashboard\Core\Kernel;

trait KernelAware
{
    /**
     * @var Kernel
     */
    private $kernel;

    public function setKernel(Kernel $kernel): void
    {
        $this->kernel = $kernel;
    }

    /**
     * @return Kernel
     */
    public function getKernel(): Kernel
    {
        return $this->kernel;
    }
}
