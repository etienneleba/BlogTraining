<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends KernelTestCase
{
    public function getValidEntity(): User
    {
        return (new User())
            ->setEmail('test@domain.fr')
            ->setFirstname('John')
            ->setLastname('Doe')
            ->setRoles(['ROLE_USER'])
            ->setPassword('$2y$10$y6FvJ3zg5sP14tB1ZvbHAuZVc6AGMuB/3g1Tt4G1kOxtD2f9oZIVa')
        ;
    }

    public function assertAsErrors(User $user, int $number = 0)
    {
        self::bootKernel();

        $error = self::$container->get('validator')->validate($user);

        $this->assertCount($number, $error);
    }

    public function testValidUser()
    {
        $user = $this->getValidEntity();
        $this->assertAsErrors($user, 0);
    }

    public function testInvalidEmail()
    {
        $user = $this->getValidEntity();
        $user->setEmail('fzerqfg');
        $this->assertAsErrors($user, 1);
    }

    public function testBlankEmail()
    {
        $user = $this->getValidEntity();
        $user->setEmail('');
        $this->assertAsErrors($user, 1);
    }

    public function testBlankFirstname()
    {
        $user = $this->getValidEntity();
        $user->setFirstname('');
        $this->assertAsErrors($user, 1);
    }

    public function testBlankLastname()
    {
        $user = $this->getValidEntity();
        $user->setLastname('');
        $this->assertAsErrors($user, 1);
    }
}
