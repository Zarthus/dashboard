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
use Zarthus\Dashboard\Core\Impl\Column as ColumnImpl;

class Column implements ColumnImpl
{
    /**
     * @var string
     */
    private $size;
    /**
     * @var string
     */
    private $contents;

    /**
     * @param string $size
     * @param string $contents
     */
    public function __construct(string $size, string $contents)
    {
        $this->size = $size;
        $this->contents = $contents;
    }

    public function size(): string
    {
        return $this->size;
    }

    public function render(): Response
    {
        return new Response($this->contents);
    }
}
