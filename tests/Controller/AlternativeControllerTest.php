<?php

namespace App\Tests;

use App\Tests\Traits\NeedLoginTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @internal
 * @coversNothing
 */
class AlternativeControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLoginTrait;

    /**
     * @var User
     */
    private $user;
    /**
     * @var KernelBrowser
     */
    private $client;
    /**
     * @var Crawler
     */
    private $crawler;

    private $fixture;

    public function setUpFixtureAndLogin()
    {
        $this->fixture = $this->loadFixtureFiles([__DIR__.'/fixtures/AlternativeTestFixtures.yaml']);

        $this->user = $this->fixture['user'];

        $this->client = static::createClient();

        $this->login($this->client, $this->user);

        $this->crawler = $this->client->request('GET', '/alternatives');
    }

    public function testUnauthenticatedUserAlternatives()
    {
        $client = static::createClient();
        $client->request('GET', '/alternatives');

        $this->assertResponseRedirects('/login');
    }

    public function testAuthenticatedUserAlternatives()
    {
        $this->setUpFixtureAndLogin();

        $this->assertResponseIsSuccessful();
    }

    public function testAlternativesFilter00()
    {
        $this->setUpFixtureAndLogin();

        $type1 = $this->fixture['type1'];
        $type2 = $this->fixture['type2'];
        $contentType1 = $this->fixture['contentType1'];
        $contentType2 = $this->fixture['contentType2'];

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());

        $form = $this->crawler->filter('form')->form();

        $this->crawler = $this->client->submit($form, [
            'filter[type]' => '',
            'filter[contentType]' => '',
        ]);

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());
    }

    public function testAlternativesFilter10()
    {
        $this->setUpFixtureAndLogin();

        $type1 = $this->fixture['type1'];
        $type2 = $this->fixture['type2'];
        $contentType1 = $this->fixture['contentType1'];
        $contentType2 = $this->fixture['contentType2'];

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());

        $form = $this->crawler->filter('form')->form();

        $this->crawler = $this->client->submit($form, [
            'filter[type]' => $type1->getId(),
            'filter[contentType]' => '',
        ]);

        $this->assertEquals(10, $this->crawler->filter('.alternative')->count());
    }

    public function testAlternativesFilter11()
    {
        $this->setUpFixtureAndLogin();

        $type1 = $this->fixture['type1'];
        $type2 = $this->fixture['type2'];
        $contentType1 = $this->fixture['contentType1'];
        $contentType2 = $this->fixture['contentType2'];

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());

        $form = $this->crawler->filter('form')->form();

        $this->crawler = $this->client->submit($form, [
            'filter[type]' => $type1->getId(),
            'filter[contentType]' => $contentType1->getId(),
        ]);

        $this->assertEquals(5, $this->crawler->filter('.alternative')->count());
    }

    public function testAlternativesFilter12()
    {
        $this->setUpFixtureAndLogin();

        $type1 = $this->fixture['type1'];
        $type2 = $this->fixture['type2'];
        $contentType1 = $this->fixture['contentType1'];
        $contentType2 = $this->fixture['contentType2'];

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());

        $form = $this->crawler->filter('form')->form();

        $this->crawler = $this->client->submit($form, [
            'filter[type]' => $type1->getId(),
            'filter[contentType]' => $contentType2->getId(),
        ]);

        $this->assertEquals(5, $this->crawler->filter('.alternative')->count());
    }

    public function testAlternativesFilter20()
    {
        $this->setUpFixtureAndLogin();

        $type1 = $this->fixture['type1'];
        $type2 = $this->fixture['type2'];
        $contentType1 = $this->fixture['contentType1'];
        $contentType2 = $this->fixture['contentType2'];

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());

        $form = $this->crawler->filter('form')->form();

        $this->crawler = $this->client->submit($form, [
            'filter[type]' => $type2->getId(),
            'filter[contentType]' => '',
        ]);

        $this->assertEquals(10, $this->crawler->filter('.alternative')->count());
    }

    public function testAlternativesFilter21()
    {
        $this->setUpFixtureAndLogin();

        $type1 = $this->fixture['type1'];
        $type2 = $this->fixture['type2'];
        $contentType1 = $this->fixture['contentType1'];
        $contentType2 = $this->fixture['contentType2'];

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());

        $form = $this->crawler->filter('form')->form();

        $this->crawler = $this->client->submit($form, [
            'filter[type]' => $type2->getId(),
            'filter[contentType]' => $contentType1->getId(),
        ]);

        $this->assertEquals(5, $this->crawler->filter('.alternative')->count());
    }

    public function testAlternativesFilter22()
    {
        $this->setUpFixtureAndLogin();

        $type1 = $this->fixture['type1'];
        $type2 = $this->fixture['type2'];
        $contentType1 = $this->fixture['contentType1'];
        $contentType2 = $this->fixture['contentType2'];

        $this->assertEquals(20, $this->crawler->filter('.alternative')->count());

        $form = $this->crawler->filter('form')->form();

        $this->crawler = $this->client->submit($form, [
            'filter[type]' => $type2->getId(),
            'filter[contentType]' => $contentType2->getId(),
        ]);

        $this->assertEquals(5, $this->crawler->filter('.alternative')->count());
    }
}
