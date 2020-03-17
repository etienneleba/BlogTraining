<?php

namespace App\Tests;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 * @coversNothing
 */
class RegistrationControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function test200StatusRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testRegistrationWithUsedEmail()
    {
        $this->loadFixtureFiles([__DIR__.'/UserTestFixtures.yaml']);
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form([
            'registration_form[email]' => 'john@domain.fr',
            'registration_form[plainPassword]' => '000000',
            'registration_form[firstname]' => 'john',
            'registration_form[lastname]' => 'doe',
        ]);
        $client->submit($form);

        $this->assertSelectorTextContains('li', 'There is already an account with this email');
    }

    public function testValidRegistration()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form([
            'registration_form[email]' => 'john@domain.fr',
            'registration_form[plainPassword]' => '000000',
            'registration_form[firstname]' => 'john',
            'registration_form[lastname]' => 'doe',
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/alternatives');
    }
}
