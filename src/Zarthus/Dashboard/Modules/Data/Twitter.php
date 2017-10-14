<?php
/**
 * dash
 *
 * @author Jos Ahrens <zarthus@liefland.net>
 * @since 2017-10-14
 * @license MIT
 */
declare(strict_types=1);

namespace Zarthus\Dashboard\Modules\Data;

use Abraham\TwitterOAuth\TwitterOAuth;
use Zarthus\Dashboard\Core\AbstractModule;
use Zarthus\Dashboard\Core\Application;
use Zarthus\Dashboard\Core\Utility\StringUtil;

class Twitter extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    public function normalizeConfig(): void
    {
        $this->config['limit'] = $this->config['limit'] ?? 10;
        $this->config['timeouts_connect'] = $this->config['timeouts_connect'] ?? 5;
        $this->config['timeouts_request'] = $this->config['timeouts_request'] ?? 5;
        $this->config['my_timeline'] = $this->config['my_timeline'] ?? false;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(): void
    {
        if (!isset($this->config['my_timeline']) || !$this->config['my_timeline']) {
            $this->requireConfigOption('follow');
        }

        $this->requireConfigOption('consumer_key');
        $this->requireConfigOption('consumer_secret');
        $this->requireConfigOption('access_token');
        $this->requireConfigOption('access_token_secret');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): string
    {
        $connection = $this->connect();

        $results = $this->config['my_timeline']
            ? $this->getMyTimeline($connection)
            : $this->getTimelines($connection, $this->config['follow']);

        return $this->render(
            $this->sliceResults(
                $this->sortResults($results),
                0,
                $this->config['limit']
            )
        );
    }

    public function getTimelines(TwitterOAuth $connection, array $follow): array
    {
        $results = [];

        foreach ($follow as $account) {
            foreach ($this->getTimeline($connection, $account) as $result) {
                $results[] = $result;
            }
        }

        return $results;
    }

    public function getMyTimeline(TwitterOAuth $connection): array
    {
        $results = [];
        $responses = $connection->get('statuses/home_timeline');

        foreach ($responses as $response) {
            $results[] = $this->parseResponse($response);
        }

        return $results;
    }

    public function getTimeline(TwitterOAuth $connection, string $account): array
    {
        $results = [];
        $responses = $connection->get('statuses/user_timeline?screen_name=' . $account . '&count=' . $this->config['limit']);

        foreach ($responses as $response) {
            $results[] = $this->parseResponse($response);
        }

        return $results;
    }

    protected function parseResponse($response): array
    {
        $icon = 'twitter';

        if (!empty($response->retweeted_status)) {
            $icon = 'retweet';
        } else if ($response->in_reply_to_status_id) {
            $icon = 'reply';
        }

        return [
            'href' => 'https://twitter.com/' . $response->user->screen_name .  '/status/' . $response->id,
            'title' => $response->text,
            'canonicalName' => $response->user->screen_name,
            'icon' => $icon,
            'date' => new \DateTime($response->created_at)
        ];
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

    protected function render(array $tweets)
    {
        $classes = $this->config['classes'] ?? '';
        $output = '';

        foreach ($tweets as $tweet) {
            $output .= "<a class=\"panel-block $classes\" href=\"{$tweet['href']}\" target=\"_blank\">";

            $output .= '<span class="panel-icon">';
            $output .= '<i class="fa fa-' . $tweet['icon'] . '"></i>';
            $output .= '</span>';

            if (!empty($tweet['canonicalName'])) {
                $output .= '<span class="tag">' . htmlentities($tweet['canonicalName'], ENT_QUOTES) . '</span>&nbsp;';
            }

            $output .= '<span title="' . htmlentities($tweet['title'], ENT_QUOTES) . '">';
            $output .= htmlentities(StringUtil::truncate($tweet['title'], 64), ENT_QUOTES);
            $output .= '</span>';
            $output .= '</a>';
            $output .= PHP_EOL;
        }

        return $output;
    }

    protected function connect(): TwitterOAuth
    {
        $connection = new TwitterOAuth(
            $this->config['consumer_key'],
            $this->config['consumer_secret'],
            $this->config['access_token'],
            $this->config['access_token_secret']
        );
        $connection->setTimeouts($this->config['timeouts_connect'], $this->config['timeouts_request']);
        $connection->setUserAgent(
            $this->config['user-agent'] ??
                $this->kernel->getName() . '/' . $this->kernel->getVersion() .
                    ' php/' . PHP_VERSION . ' module-hashcode/' . StringUtil::truncate($this->hashCode(), 7, '')
        );
        $connection->get('account/verify_credentials');

        return $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCacheTtl(): int
    {
        return 300;
    }
}
