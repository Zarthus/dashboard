<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-10
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Ds;

use \Zarthus\Dashboard\Core\Impl\Collection as CollectionImpl;

class Collection implements CollectionImpl
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data data to prefill
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param mixed $value
     */
    public function add($value): void
    {
        $this->data[] = $value;
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->data[$key];
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function exists($key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @param mixed $key
     */
    public function delete($key): void
    {
        unset($this->data[$key]);
    }

    /**
     * @return \Zarthus\Dashboard\Core\Impl\Collection
     */
    public function copy(): CollectionImpl
    {
        return new self($this->data);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    public function next(): void
    {
        next($this->data);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return current($this->data) !== false && key($this->data) !== null;
    }

    public function rewind(): void
    {
        reset($this->data);
    }
}
