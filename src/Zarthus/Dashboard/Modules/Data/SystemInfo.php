<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Modules\Data;

use Zarthus\Dashboard\Core\AbstractModule;

class SystemInfo extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    public function validate(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): string
    {
        $info = [];

        foreach ($this->config as $option => $enabled) {
            if (method_exists($this, 'retrieve' . $option)) {
                if (!$enabled) {
                    continue;
                }

                $cleanOption = ucwords(trim(preg_replace(
                    '/([A-Z])/',
                    ' \\1',
                    str_replace('Info', '', $option)
                )));
                $method = 'retrieve' . $option;

                $info[$cleanOption] = $this->$method();
            }
        }

        return $this->toOutput($info);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCacheTtl(): int
    {
        return 10;
    }

    protected function retrieveOsInfo(): string
    {
        return php_uname();
    }

    protected function retrieveUptime(): string
    {
        if ($this->getOperatingSystemName() === 'Windows') {
            return 'Unknown';
        }

        exec('uptime', $return);

        return implode(', ', $return);
    }

    protected function retrieveCpuInfo(): int
    {
        // TODO
        return random_int(0, 100);
    }

    protected function retrieveRamUsage(): string
    {
        // TODO
        return '0';
    }

    protected function retrieveSwapUsage(): string
    {
        // TODO
        return '0';
    }

    protected function toOutput(array $info): string
    {
        $output = '<ul>';
        foreach ($info as $key => $value) {
            $output .= '<li>' . $key . ': ' . $this->colorize($key, $value) . '</li>';
        }
        $output .= '</ul>';

        return $output;
    }

    protected function colorize(string $key, $value): string
    {
        if (!$this->shouldColorize()) {
            return (string) $value;
        }

        if (is_int($value) && $value >= 0 && $value <= 100) {
            if ($value > $this->config['num_danger'] ?? 75) {
                return '<span class="is-danger">' . $value . '</span>';
            }

            if ($value > $this->config['num_warning'] ?? 50) {
                return '<span class="is-warning">' . $value . '</span>';
            }

            return '<span class="is-info">' . $value . '</span>';
        }

        return (string) $value;
    }

    protected function shouldColorize(): bool
    {
        return $this->getBooleanOption('colorize');
    }

    protected function getBooleanOption(string $key): bool
    {
        return isset($this->config[$key]) && $this->config[$key];
    }

    /**
     * Word of warning: only is reliable for detecting Windows at the moment (<=7.1.x)
     *
     * @return string
     */
    protected function getOperatingSystemName(): string
    {
        if (defined('PHP_OS_FAMILY') && version_compare(PHP_VERSION, '7.2.0', '>=')) {
            $os = PHP_OS_FAMILY;
        } else {
            $os = PHP_OS;

            if (strpos('WIN', $os)) {
                $os = 'Windows';
            }
        }

        return $os;
    }
}
