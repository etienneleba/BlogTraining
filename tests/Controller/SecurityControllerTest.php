<?php

namespace App\Tests;

use App\Tests\Traits\NeedLoginTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLoginTrait;

    public function testUnauthenticatedUserLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }

    public function testAuthenticatedUserRegister()
    {
        $client = static::createClient();
        $this->login($client);
        $client->request('GET', '/login');
        $this->assertResponseRedirects('/alternatives');
    }

    public function testLoginWithUnknowEmail()
    {
        $this->loadFixtureFiles([dirname(__DIR__).'/GlobalFixtures/UserTestFixtures.yaml']);
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form([
            'email' => 'john@doe.fr',
            'password' => 'fakepassword',
        ]);

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertContains('Email could not be found.', $crawler->html());
    }

    public function testLoginWithBadCredentials()
    {
        $this->loadFixtureFiles([dirname(__DIR__).'/GlobalFixtures/UserTestFixtures.yaml']);
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form([
            'email' => 'john@domain.fr',
            'password' => 'fakepassword',
        ]);

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertContains('Invalid credentials', $crawler->html());
    }

    public function testLoginWithGoodCredentials()
    {
        $this->loadFixtureFiles([dirname(__DIR__).'/GlobalFixtures/UserTestFixtures.yaml']);
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form([
            'email' => 'john@domain.fr',
            'password' => '000000',
        ]);
        $client->submit($form);

        $this->assertResponseRedirects('/alternatives');
    }

    public function testRedirectionWhenUserAlreadyLogin()
    {
        $client = static::createClient();
        $this->login($client);
        $client->request('GET', '/login');

        $this->assertResponseRedirects('/alternatives');
    }
}
