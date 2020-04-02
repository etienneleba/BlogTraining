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
        $this->client = static::createClient();
        $this->user = $this->login($this->client);
    }

    public function testProfile()
    {
        $this->client->request('GET', '/user/profile');

        $this->assertResponseIsSuccessful();
    }

    public function testUserProfileData()
    {
        $crawler = $this->client->request('GET', '/user/profile');

        $this->assertContains($this->user->getEmail(), $crawler->filter('.info')->getNode(0)->nodeValue);
        $this->assertContains(ucfirst($this->user->getFirstname()), $crawler->filter('.info')->getNode(1)->nodeValue);
        $this->assertContains(ucfirst($this->user->getLastname()), $crawler->filter('.info')->getNode(2)->nodeValue);
    }

    public function testUserAlternatives()
    {
        $crawler = $this->client->request('GET', '/user/profile');

        $this->assertEquals(count($this->user->getAlternatives()->toArray()), $crawler->filter('div.alternative')->count());
    }
}
