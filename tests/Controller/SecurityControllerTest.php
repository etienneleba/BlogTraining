<?php

namespace App\Tests;

use App\Tests\Traits\NeedLoginTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 * @coversNothing
 */
class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLoginTrait;

    public function test200StatusLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testH1Login()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertSelectorTextContains('h1', 'sign in');
    }

    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form([
            'email' => 'john@doe.fr',
            'password' => 'fakepassword',
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testLoginWithGoodCredentials()
    {
        $this->loadFixtureFiles([__DIR__.'/UserTestFixtures.yaml']);
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
        $users = $this->loadFixtureFiles([__DIR__.'/UserTestFixtures.yaml']);
        $client = static::createClient();
        $this->login($client, $users['user1']);
        $client->request('GET', '/login');

        $this->assertResponseRedirects('/alternatives');
    }
}