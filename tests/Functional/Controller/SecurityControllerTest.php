<?php

namespace App\Tests\Functional\Controller;

use App\Tests\ExtendedWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class SecurityControllerTest extends ExtendedWebTestCase
{
    public function testRedirectToLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRedirect($client, '/login');
    }

    public function testLoginFormRenders()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('div.login-form'));
        $this->assertCount(1, $crawler->filter('form'));
        $this->assertCount(1, $crawler->filter('form input[name="_username"]'));
        $this->assertCount(1, $crawler->filter('form input[name="_password"]'));
        $this->assertCount(1, $crawler->filter('form button[type="submit"]'));
    }

    public function testLoginFailure()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $client->submitForm('Log in', $this->getLoginNotExistingCredentials());

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRedirect($client, '/login');

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('div.error'));

        $this->assertSelectorTextContains('div.error', 'Invalid credentials');
    }

    public function testLoginSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $client->submitForm('Log in', $this->getLoginExistingUserCredentials());

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRedirect($client, '/');

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $crawler->filter('.navbar'));
        $this->assertSelectorTextContains('.navbar', 'Logged in as');
        $this->assertSelectorTextContains('.navbar a', 'Log Out');
    }

    public function testLogout()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $client->request('GET', '/login');

        $crawler = $client->submitForm('Log in', $this->getLoginExistingUserCredentials());

        $client->followRedirects(false);

        $link = $crawler->selectLink('Log Out')->link();
        $client->click($link);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRedirect($client, '/');

        $client->followRedirect();

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRedirect($client, '/login');
    }
}
