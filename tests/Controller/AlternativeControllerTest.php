<?php

namespace App\Tests;

use App\Tests\Traits\NeedLoginTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class AlternativeControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLoginTrait;

    public function testUserGrantedRoleUser()
    {
        $client = static::createClient();
        $client->request('GET', '/alternatives');

        $this->assertResponseRedirects('/login');
    }

    public function testh1Alternatives()
    {
        $users = $this->loadFixtureFiles([__DIR__.'/UserTestFixtures.yaml']);

        $client = static::createClient();
        $this->login($client, $users['user1']);
        $client->request('GET', '/alternatives');
        $this->assertSelectorTextContains('h1', 'Democratic alternatives');
    }

    public function testAlternativesAreDisplayed()
    {
        $alternatives = $this->loadFixtureFiles([__DIR__.'/AlternativeTestFixtures.yaml']);
        $client = static::createClient();

        $user = $this->loadFixtureFiles([__DIR__.'/UserTestFixtures.yaml']);

        $this->login($client, $user['user1']);

        $crawler = $client->request('GET', '/alternatives');

        $this->assertSelectorTextContains('h1', 'Democratic alternatives');

        $this->assertEquals(10, $crawler->filter('div.alternative')->count());
    }

    public function testUserHeader()
    {
        $users = $this->loadFixtureFiles([__DIR__.'/UserTestFixtures.yaml']);

        $client = static::createClient();
        $this->login($client, $users['user1']);
        $crawler = $client->request('GET', '/alternatives');

        $this->assertSelectorExists('.header');
        $this->assertEquals('/alternatives', $crawler->filter('a')->eq(0)->link()->getNode()->getAttribute('href'));
        $this->assertEquals('/logout', $crawler->filter('a')->eq(1)->link()->getNode()->getAttribute('href'));
        $this->assertEquals('/user/profile', $crawler->filter('a')->eq(2)->link()->getNode()->getAttribute('href'));
    }
}
