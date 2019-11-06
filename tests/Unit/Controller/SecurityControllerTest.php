<?php

namespace App\Tests\Unit\Controller;

use App\Controller\SecurityController;
use PHPUnit\Framework\TestCase;

class SecurityControllerTest extends TestCase
{
    public function testLogout()
    {
        $controller = new SecurityController();
        $result     = $controller->logout();
        self::assertNull($result);
    }
}