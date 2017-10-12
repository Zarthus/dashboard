<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-12
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Modules\Constant;

use Zarthus\Dashboard\Core\AbstractModule;

class StaticHtml extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    public function validate(): void
    {
        $this->requireConfigOption('text');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): string
    {
        return $this->config['text'];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCacheTtl(): int
    {
        return 3600;
    }
}
