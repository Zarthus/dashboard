<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-10
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zarthus\Dashboard\Core\Html\Layout;

final class Router
{
    /**
     * @var Kernel
     */
    private $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function index(Request $request): Response
    {
        return $this->loadLayout($request, 'index')->render();
    }

    private function loadLayout(Request $request, string $name): Layout
    {
        return new Layout($this->kernel, $request, $name);
    }
}
