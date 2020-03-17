<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 * @coversNothing
 */
class BaseControllerTest extends WebTestCase
{
    public function test200StatusHome()
    {
        $client = static::createClient();
        $client->request('GET', '/home');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomeTitle()
    {
        $client = static::createClient();
        $client->request('GET', '/home');

        $this->assertSelectorTextContains('h1', 'Imagine your own Democracy');
    }

    public function testNumberOfLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertEquals(2, $crawler->filter('a')->count());
    }
}
