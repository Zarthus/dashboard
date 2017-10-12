<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Impl;

interface Collection extends \Iterator, \Countable, \JsonSerializable
{
    public function clear(): void;

    public function copy(): self;

    public function isEmpty(): bool;

    public function toArray(): array;
}
