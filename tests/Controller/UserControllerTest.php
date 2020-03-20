<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\Traits\NeedLoginTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class UserControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLoginTrait;

    /** @var KernelBrowser $client */
    private $client;

    /** @var User $user */
    private $user;

    public function setUp()
    {
        $fixture = $this->loadFixtureFiles([__DIR__.'/UserTestFixtures.yaml']);

        $this->client = static::createClient();
        $this->user = $fixture['user1'];
        $this->login($this->client, $this->user);
    }

    public function test200StatusUser()
    {
        $this->client->request('GET', '/user/profile');

        $this->assertResponseIsSuccessful();
    }

    public function testh1User()
    {
        $this->client->request('GET', '/user/profile');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'User profile');
    }

    public function testUserProfile()
    {
        $crawler = $this->client->request('GET', '/user/profile');

        $this->assertSelectorTextContains('h2', 'My profile');

        $this->assertEquals($this->user->getEmail(), $crawler->filter('.info')->getNode(0)->nodeValue);
        $this->assertEquals($this->user->getFirstname(), $crawler->filter('.info')->getNode(1)->nodeValue);
        $this->assertEquals($this->user->getLastname(), $crawler->filter('.info')->getNode(2)->nodeValue);
    }

    public function testUserAlternatives()
    {
        $crawler = $this->client->request('GET', '/user/profile');

        $this->assertEquals('My alternatives', $crawler->filter('h2')->getNode(1)->nodeValue);

        $this->assertEquals(count($this->user->getAlternatives()->toArray()), $crawler->filter('div.alternative')->count());
    }
}
