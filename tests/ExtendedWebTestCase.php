<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class ExtendedWebTestCase extends WebTestCase
{
    public function setUp(): void
    {
        $this->runCommand('doctrine:fixtures:load');
    }

    protected function assertRedirect(KernelBrowser $client, $path)
    {
        $redirectTo = str_replace(
            $client->getRequest()->getSchemeAndHttpHost(),
            '',
            $client->getResponse()->headers->get('location')
        );

        $this->assertEquals($redirectTo, $path);
    }

    protected function getLoginExistingUserCredentials()
    {
        return [
            '_username' => 'existing_user@example.com',
            '_password' => 'correct_password',
        ];
    }

    protected function getLoginNotExistingCredentials()
    {
        return [
            '_username' => 'not_existing_user@example.com',
            '_password' => 'any_password',
        ];
    }
}
