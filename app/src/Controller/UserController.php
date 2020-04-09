<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        $user = $this->getUser();

        return $this->render('user/view.html.twig', [
            'user' => $user,
            'profile' => true,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="view_user")
     */
    public function view(User $user)
    {
        return $this->render('user/view.html.twig', [
            'user' => $user,
            'profile' => false,
        ]);
    }
}
