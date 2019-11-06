<?php

namespace App\Tests\Unit\Controller;

use App\Controller\RSSFeedController;
use PHPUnit\Framework\TestCase;

class RssFeedControllerTest extends TestCase
{
    public static function callMethod($obj, $name, array $args)
    {
        $class  = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method->invokeArgs($obj, $args);
    }

    public function testGetFrequentWords()
    {
        $controller = new RSSFeedController();

        $result = self::callMethod(
            $controller,
            'getFrequentWords',
            [
                str_repeat('hello ', 10)
                . str_repeat('world ', 9)
                . str_repeat('php ', 11)
                . str_repeat('javascript ', 15)
                . str_repeat('ajax ', 20),
                ['ajax', 'php'],
                $limit = 2
            ]
        );

        $this->assertIsArray($result);
        $this->assertArrayNotHasKey('ajax', $result);
        $this->assertArrayNotHasKey('php', $result);
        $this->assertArrayHasKey('hello', $result);
        $this->assertArrayHasKey('javascript', $result);
        $this->assertEquals(15, $result['javascript']);
        $this->assertEquals(10, $result['hello']);
        $this->assertCount(2, $result);
    }
}