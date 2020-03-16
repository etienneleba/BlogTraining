<?php

namespace App\Tests\Entity;

use App\Entity\Alternative;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 * @coversNothing
 */
class AlternativeTest extends KernelTestCase
{
    public function getValidEntity(): Alternative
    {
        return (new Alternative())
            ->setTitle('Test title')
            ->setDescription('Test description')
            ->setContent('Test content')
        ;
    }

    public function assertAsErrors(Alternative $alternative, int $number = 0)
    {
        self::bootKernel();

        $error = self::$container->get('validator')->validate($alternative);

        $this->assertCount($number, $error);
    }

    public function testValidAlternative()
    {
        $alternative = $this->getValidEntity();

        $this->assertAsErrors($alternative, 0);
    }

    public function testBlankTitle()
    {
        $alternative = $this->getValidEntity();
        $alternative->setTitle('');

        $this->assertAsErrors($alternative, 1);
    }

    public function testBlankDescription()
    {
        $alternative = $this->getValidEntity();
        $alternative->setDescription('');

        $this->assertAsErrors($alternative, 1);
    }

    public function testTooLongDescription()
    {
        $alternative = $this->getValidEntity();
        $alternative->setDescription("Character Counter is a 100% free online character count calculator that's simple to use. Sometimes users prefer simplicity over all of the detailed writing information Word Counter provides, and this is exactly what this tool offers. It displays character count and word count which is often the only information a person needs to know about their writing. Best of all, you receive the needed information at a lightning fast speed.");

        $this->assertAsErrors($alternative, 1);
    }

    public function testBlankContent()
    {
        $alternative = $this->getValidEntity();
        $alternative->setContent('');

        $this->assertAsErrors($alternative, 1);
    }
}
