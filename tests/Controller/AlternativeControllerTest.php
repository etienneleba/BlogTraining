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

    public function testUnauthenticatedUserAlternatives()
    {
        $client = static::createClient();
        $client->request('GET', '/alternatives');

        $this->assertResponseRedirects('/login');
    }

    public function testAuthenticatedUserAlternatives()
    {
        $client = static::createClient();

        $this->login($client);

        $client->request('GET', '/alternatives');

        $this->assertResponseIsSuccessful();
    }

    public function testAlternativesAreDisplayed()
    {
        $client = static::createClient();

        $this->login($client);

        $crawler = $client->request('GET', '/alternatives');

        $this->assertEquals(10, $crawler->filter('div.alternative')->count());
    }
}
