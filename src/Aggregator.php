<?php

namespace Aggregators\Larashout;

use Carbon\Carbon;
use InvalidArgumentException;
use Aggregators\Support\BaseAggregator;
use Symfony\Component\DomCrawler\Crawler;

class Aggregator extends BaseAggregator
{
    /**
     * {@inheritDoc}
     */
    public string $uri = 'https://www.larashout.com/category/laravel';

    /**
     * {@inheritDoc}
     */
    public string $provider = 'Larashout';

    /**
     * {@inheritDoc}
     */
    public string $logo = 'logo.jpg';

    /**
     * {@inheritDoc}
     */
    public function articleIdentifier(): string
    {
        return 'main.list-section > div.container > div.row > div.col-xs-12.col-sm-6.col-md-4';
    }

    /**
     * {@inheritDoc}
     */
    public function nextUrl(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div.pagination > a:last-of-type')->first()->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function image(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('article > a > img')->attr('src');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function title(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('h2')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function content(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div.list-item__excerpt')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function link(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('article > a')->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateCreated(Crawler $crawler): Carbon
    {
        try {
            return Carbon::parse($crawler->filter('time')->text());
        } catch (InvalidArgumentException $e) {
            return Carbon::now();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateUpdated(Crawler $crawler): Carbon
    {
        return $this->dateCreated($crawler);
    }
}
