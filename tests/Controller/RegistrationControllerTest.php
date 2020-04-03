<?php

namespace App\Tests;

use App\Tests\Traits\NeedLoginTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class RegistrationControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLoginTrait;

    public function testUnauthenticatedUserRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
    }

    public function testAuthenticatedUserRegister()
    {
        $fixture = $this->loadFixtureFiles([dirname(__DIR__).'/GlobalFixtures/UserTestFixtures.yaml']);
        $client = static::createClient();
        $this->login($client, $fixture['user']);
        $client->request('GET', '/register');
        $this->assertResponseRedirects('/alternatives');
    }

    public function testRegistrationWithUsedEmail()
    {
        $this->loadFixtureFiles([dirname(__DIR__).'/GlobalFixtures/UserTestFixtures.yaml']);
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form([
            'registration_form[email]' => 'john@domain.fr',
            'registration_form[plainPassword]' => '000000',
            'registration_form[firstname]' => 'john',
            'registration_form[lastname]' => 'doe',
        ]);
        $crawler = $client->submit($form);

        $this->assertContains('There is already an account with this email', $crawler->html());
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
