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
use Zarthus\Dashboard\Core\Utility\StringUtil;
use Zend\Feed\Reader\Reader;

/**
 * Best used with the 'presets.panel_list' template. This module just validates
 * your configuration.
 */
class RssFeed extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    public function normalizeConfig(): void
    {
        $this->config['limit'] = $this->config['limit'] ?? 10;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(): void
    {
        $this->requireConfigOption('feeds');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): string
    {
        return $this->render(
            $this->sliceResults(
                $this->sortResults($this->retrieveFeeds($this->config['feeds'])),
                0,
                $this->config['limit']
            )
        );
    }

    public function retrieveFeeds(array $feeds): array
    {
        $results = [];

        foreach ($feeds as $feed) {
            foreach ($this->retrieveFeed($feed) as $result) {
                $results[] = $result;
            }
        }

        return $results;
    }

    public function retrieveFeed(string $uri): array
    {
        $results = [];

        $feed = Reader::import($uri);

        /**
         * @var $element \Zend\Feed\Reader\Entry\Rss
         */
        foreach ($feed as $element) {
            $results[] = [
                'href' => $element->getLink(),
                'title' => $element->getTitle(),
                'canonicalName' => parse_url($element->getLink())['host'] ?? null,
                'date' => $element->getDateModified() ?? $element->getDateCreated(),
            ];
        }

        return $results;
    }

    protected function sortResults(array $results): array
    {
        $sortedResults = $results;

        usort($sortedResults, function ($feed1, $feed2) {
            return $feed1['date'] > $feed2['date'];
        });

        return $sortedResults;
    }

    protected function sliceResults(array $results, int $start, int $end): array
    {
        return array_slice($results, $start, $end);
    }

    protected function render(array $feeds)
    {
        $classes = $this->config['classes'] ?? '';
        $output = '';

        foreach ($feeds as $feed) {
            $output .= "<a class=\"panel-block $classes\" href=\"{$feed['href']}\" target=\"_blank\">";

            $output .= '<span class="panel-icon">';
            $output .= '<i class="fa fa-rss"></i>';
            $output .= '</span>';

            if (!empty($feed['canonicalName'])) {
                $output .= '<span class="tag">' . htmlentities($feed['canonicalName'], ENT_QUOTES) . '</span>&nbsp;';
            }

            $output .= '<span title="' . htmlentities($feed['title'], ENT_QUOTES) . '">';
            $output .= htmlentities(StringUtil::truncate($feed['title'], 64), ENT_QUOTES);
            $output .= '</span>';
            $output .= '</a>';
            $output .= PHP_EOL;
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCacheTtl(): int
    {
        return 300;
    }
}
