<?php

namespace App\Tests\Unit\Entity;

use App\Entity\TheRegisterCoUkSoftwareHeadlinesFeed;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TheRegisterCoUkSoftwareHeadlinesFeedTest extends TestCase
{
    public function testTheRegisterCoUkSoftwareHeadlinesFeedEntity()
    {
        $feed = new TheRegisterCoUkSoftwareHeadlinesFeed();

        $this->assertInstanceOf(
            TheRegisterCoUkSoftwareHeadlinesFeed::class,
            $feed->setSummary('summary text')
        );
        $this->assertInstanceOf(
            TheRegisterCoUkSoftwareHeadlinesFeed::class,
            $feed->setTitle('title text')
        );
        $this->assertInstanceOf(
            TheRegisterCoUkSoftwareHeadlinesFeed::class,
            $feed->setAuthorName('author name text')
        );
        $now = new \DateTime();
        $this->assertInstanceOf(
            TheRegisterCoUkSoftwareHeadlinesFeed::class,
            $feed->setDate($now)
        );
        $this->assertInstanceOf(
            TheRegisterCoUkSoftwareHeadlinesFeed::class,
            $feed->setAuthorUri('author uri text')
        );
        $this->assertInstanceOf(
            TheRegisterCoUkSoftwareHeadlinesFeed::class,
            $feed->setLink('link text')
        );
        $this->assertEquals('summary text', $feed->getSummary());
        $this->assertEquals('title text', $feed->getTitle());
        $this->assertEquals('link text', $feed->getLink());
        $this->assertEquals('author name text', $feed->getAuthorName());
        $this->assertEquals('author uri text', $feed->getAuthorUri());
        $this->assertInstanceOf(\DateTimeInterface::class, $feed->getDate());
        $this->assertEquals($now, $feed->getDate());

        $array = $feed->toArray();
        $this->assertIsArray($array);
        $this->assertArrayHasKey('summary', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('link', $array);
        $this->assertArrayHasKey('authorName', $array);
        $this->assertArrayHasKey('authorUri', $array);
        $this->assertArrayHasKey('date', $array);
    }
}
