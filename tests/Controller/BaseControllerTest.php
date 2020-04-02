<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class BaseControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
    }

    public function testNumberOfLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertEquals(5, $crawler->filter('a')->count());
    }

    public function testLoginLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $link = $crawler->selectLink('Login')->link();

        $crawler = $client->click($link);

        $this->assertRouteSame('login');
    }

    public function testRegisterLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $link = $crawler->selectLink('Register')->link();

        $client->click($link);

        $this->assertRouteSame('register');
    }
}
