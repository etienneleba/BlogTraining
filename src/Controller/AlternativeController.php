<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AlternativeController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/alternatives", name="alternatives")
     */
    public function index()
    {
        return $this->render('alternative/index.html.twig');
    }
}
