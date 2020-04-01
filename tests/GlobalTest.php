<?php

namespace App\Tests;

use App\Tests\Traits\NeedLoginTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class GlobalTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLoginTrait;

    public function testAuthenticatedUserHeader()
    {
        $fixture = $this->loadFixtureFiles([__DIR__.'/GlobalFixtures/UserTestFixtures.yaml']);

        $client = static::createClient();
        $this->login($client, $fixture['user']);
        $crawler = $client->request('GET', '/alternatives');

        $this->assertSelectorExists('.navbar');
        $this->assertEquals('/alternatives', $crawler->filter('a')->eq(1)->link()->getNode()->getAttribute('href'));
        $this->assertEquals('/home', $crawler->filter('a')->eq(0)->link()->getNode()->getAttribute('href'));
        $this->assertEquals('/logout', $crawler->filter('a')->eq(3)->link()->getNode()->getAttribute('href'));
        $this->assertEquals('/user/profile', $crawler->filter('a')->eq(2)->link()->getNode()->getAttribute('href'));
    }
}
