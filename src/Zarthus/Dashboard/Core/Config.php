<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-09
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Core;

use Zarthus\Dashboard\Core\Ds\Collection;
use Zarthus\Dashboard\Core\Exception\Fatal\InvalidConfigurationException;

class Config extends Collection
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     *
     * @throws InvalidConfigurationException
     */
    public function __construct(string $name)
    {
        $this->name = $name;

        if (strpos($name, '.') !== false) {
            throw new InvalidConfigurationException('Illegal character "." in config name: ' . $name);
        }

        $path = Directory::CONFIG . '/' . $name . '.php';

        if (!file_exists($path)) {
            throw new InvalidConfigurationException('File not found: ' . $path);
        }

        if (!is_file($path) || !is_readable($path)) {
            throw new InvalidConfigurationException('Cannot read file: ' . $path);
        }

        parent::__construct(
            include Directory::CONFIG . '/' . $name . '.php'
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
