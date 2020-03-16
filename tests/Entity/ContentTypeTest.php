<?php

namespace App\Tests\Entity;

use App\Entity\ContentType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 * @coversNothing
 */
class ContentTypeTest extends KernelTestCase
{
    public function getValidEntity(): ContentType
    {
        return (new ContentType())
            ->setName('testContentType')
        ;
    }

    public function assertAsErrors(ContentType $contentType, int $number = 0)
    {
        self::bootKernel();

        $error = self::$container->get('validator')->validate($contentType);

        $this->assertCount($number, $error);
    }

    public function testValidContentType()
    {
        $this->assertAsErrors($this->getValidEntity());
    }

    public function testBlankName()
    {
        $contentType = $this->getValidEntity();
        $contentType->setName('');

        $this->assertAsErrors($contentType, 1);
    }
}
