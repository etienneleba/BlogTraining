<?php

namespace App\Tests\Entity;

use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 * @coversNothing
 */
class TypeTest extends KernelTestCase
{
    public function getValidEntity(): Type
    {
        return (new Type())
            ->setName('testType')
        ;
    }

    public function assertAsErrors(Type $type, int $number = 0)
    {
        self::bootKernel();

        $error = self::$container->get('validator')->validate($type);

        $this->assertCount($number, $error);
    }

    public function testValidType()
    {
        $this->assertAsErrors($this->getValidEntity(), 0);
    }

    public function testBlankName()
    {
        $type = $this->getValidEntity();
        $type->setName('');

        $this->assertAsErrors($type, 1);
    }
}
