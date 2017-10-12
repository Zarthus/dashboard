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

interface Module
{
    /**
     * @throws \Zarthus\Dashboard\Core\Exception\Module\ValidationException
     */
    public function validate(): void;

    public function runExecute(): string;

    public function execute(): string;

    public function getName(): string;

    public function getConfig(): array;

    /**
     * Not currently in use. In future we wish to cache on
     * per-module basis.
     *
     * Should be the TTL to persist the cache as a constant.
     *
     * Should never be 0, even if it's a static text module,
     * it's barely harmful for performance to re-render it every
     * once in a while.
     *
     * @return int
     */
    public function getCacheTtl(): int;

    public function hashCode(): string;
}
