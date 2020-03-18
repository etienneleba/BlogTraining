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
        $fixtures = $this->loadFixtureFiles([__DIR__.'/AlternativeControllerTestFixtures.yaml']);
        $client = static::createClient();

        $this->login($client, $fixtures['user1']);

        $crawler = $client->request('GET', '/alternatives');

        $this->assertSelectorTextContains('h1', 'Democratic alternatives');

        $this->assertEquals(10, $crawler->filter('div.alternative')->count());
    }
}
