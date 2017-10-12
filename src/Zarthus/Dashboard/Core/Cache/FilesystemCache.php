<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core\Cache;

use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use Zarthus\Dashboard\Core\Directory;

class FilesystemCache
{
    /**
     * @var AdapterInterface
     */
    public $adapter;
    /**
     * @var Filesystem
     */
    public $filesystem;
    /**
     * @var FilesystemCachePool
     */
    public $pool;

    public static function fromApplication(): FilesystemCache
    {
        $adapter = new Local(Directory::ROOT);
        $filesystem = new Filesystem($adapter);

        $pool = new FilesystemCachePool($filesystem);
        $pool->setFolder('/var/cache/dash');

        return new self($adapter, $filesystem, $pool);
    }

    public function __construct(AdapterInterface $adapter, Filesystem $filesystem, FilesystemCachePool $pool)
    {
        $this->adapter = $adapter;
        $this->filesystem = $filesystem;
        $this->pool = $pool;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * @return FilesystemCachePool
     */
    public function getPool(): FilesystemCachePool
    {
        return $this->pool;
    }
}
