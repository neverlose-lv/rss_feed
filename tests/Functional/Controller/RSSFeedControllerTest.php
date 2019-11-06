<?php

namespace App\Tests\Functional\Controller;

use App\Tests\ExtendedWebTestCase;

class RSSFeedControllerTest extends ExtendedWebTestCase
{
    public function testRSSFeedPageRenders()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $client->followRedirects(true);
        $crawler = $client->submitForm('Log in', $this->getLoginExistingUserCredentials());

        $this->assertCount(1, $crawler->filter('.frequent-words'));
        $this->assertSelectorTextContains('.frequent-words h3','TOP 10 frequent words');
        $this->assertCount(1, $crawler->filter('.frequent-words__list'));
        $this->assertCount(10, $crawler->filter('.frequent-words__list .list-group-item'));

        $this->assertCount(1, $crawler->filter('.rss-feed'));
        $this->assertSelectorTextContains('.rss-feed h3','RSS Feed');
        $this->assertGreaterThan(10, count($crawler->filter('.rss-feed .card')));
    }
}
