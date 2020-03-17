<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class AlternativeControllerTest extends WebTestCase
{
    public function testUserGrantedRoleUser()
    {
        $client = static::createClient();
        $client->request('GET', '/alternatives');

        $this->assertResponseRedirects('/login');
    }

    public function testh1Alternatives()
    {
        $client = static::createClient();
        $client->request('GET', '/alternatives');
        $this->assertSelectorTextContains('h1', 'Democratic alternatives');
    }

    public function testCountAlternatives()
    {
    }
}
