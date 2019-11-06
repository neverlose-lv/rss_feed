<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserEntity()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setPassword('123456'));
        $this->assertInstanceOf(User::class, $user->setEmail('test@example.com'));
        $this->assertInstanceOf(User::class, $user->setRoles(['ROLE_ADMIN']));
        $this->assertEquals('123456', $user->getPassword());
        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertNull($user->eraseCredentials());
        $this->assertNull($user->getId());
        $this->assertNull($user->getSalt());
        $this->assertIsArray($user->getRoles());
        $this->assertEquals('test@example.com', $user->getUsername());
    }
}
