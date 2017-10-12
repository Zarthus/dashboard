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

use League\Plates\Engine;
use Zarthus\Dashboard\Core\Directory;

trait RendersTemplates
{
    public function renderTemplate(string $template, array $options = []): string
    {
        $templates = new Engine(Directory::VIEWS);

        return $templates->render($template, $options);
    }
}
