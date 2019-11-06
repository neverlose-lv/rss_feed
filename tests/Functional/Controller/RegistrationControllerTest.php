<?php

namespace App\Tests\Functional\Controller;

use App\Tests\ExtendedWebTestCase;

class RegistrationControllerTest extends ExtendedWebTestCase
{
    public function testRegistrationFormRenders()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('div.registration-form'));
        $this->assertCount(1, $crawler->filter('form'));
        $this->assertCount(1, $crawler->filter('form input[name="registration_form[email]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="registration_form[plainPassword]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="registration_form[_token]"]'));
        $this->assertCount(1, $crawler->filter('form button[type="submit"]'));
    }

    public function testInvalidRegistrationForm()
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $crawler = $client->submitForm('Register', $this->getInvalidCredentials());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('div#registration_form_email_errors'));
        $this->assertSelectorTextContains(
            'div#registration_form_email_errors',
            'The e-mail you have entered seems to be invalid'
        );
    }

    public function testExistingUser()
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $crawler = $client->submitForm('Register', $this->getExistingUserCredentials());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $crawler->filter('div#registration_form_email_errors'));
        $this->assertSelectorTextContains(
            'div#registration_form_email_errors',
            'There is already an account with this email'
        );
    }

    public function testValidRegistrationForm()
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $client->submitForm('Register', $this->getNotExistingCredentials());


        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertRedirect($client, '/');

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $crawler->filter('.navbar'));
        $this->assertSelectorTextContains('.navbar', 'Logged in as');
        $this->assertSelectorTextContains('.navbar a', 'Log Out');
    }

    public function testNotExistingUserEmail()
    {
        $client = static::createClient();
        $client->xmlHttpRequest('POST', '/check_email', ['email' => $this->getNotExistingUserEmail()]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(json_encode(['status' => false]), $client->getResponse()->getContent());
    }

    public function testExistingUserEmail()
    {
        $client = static::createClient();
        $client->xmlHttpRequest('POST', '/check_email', ['email' => $this->getExistingUserEmail()]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(json_encode(['status' => true]), $client->getResponse()->getContent());
    }

    protected function getInvalidCredentials()
    {
        return [
            'registration_form[email]'         => 'new_user',
            'registration_form[plainPassword]' => 'any_password',
        ];
    }

    protected function getExistingUserCredentials()
    {
        return [
            'registration_form[email]'         => $this->getExistingUserEmail(),
            'registration_form[plainPassword]' => 'correct_password',
        ];
    }

    protected function getNotExistingCredentials()
    {
        return [
            'registration_form[email]'         => $this->getNotExistingUserEmail(),
            'registration_form[plainPassword]' => 'any_password',
        ];
    }

    protected function getExistingUserEmail()
    {
        return 'existing_user@example.com';
    }

    protected function getNotExistingUserEmail()
    {
        return 'not_existing_user@example.com';
    }
}
