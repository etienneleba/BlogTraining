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

        $this->assertEquals(4, $crawler->filter('a')->count());
    }

    public function testLoginLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $link = $crawler->selectLink('Login')->link();

        $client->click($link);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'sign in');
    }

    public function testRegisterLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $link = $crawler->selectLink('Register')->link();

        $client->click($link);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Register');
    }

    public function testHeader()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertSelectorExists('.header');
        $this->assertEquals('/alternatives', $crawler->filter('a')->eq(0)->link()->getNode()->getAttribute('href'));
        $this->assertEquals('/login', $crawler->filter('a')->eq(1)->link()->getNode()->getAttribute('href'));
    }
}
