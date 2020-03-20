<?php

namespace App\Controller;

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
    public function index()
    {
        $alternatives = $this->getUser()->getAlternatives();

        return $this->render('user/profile.html.twig', [
            'alternatives' => $alternatives,
        ]);
    }
}
