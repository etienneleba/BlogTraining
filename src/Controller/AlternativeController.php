<?php

namespace App\Controller;

use App\Entity\Alternative;
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
        $alternatives = $this->getDoctrine()->getRepository(Alternative::class)->findAll();

        return $this->render('alternative/index.html.twig', [
            'alternatives' => $alternatives,
        ]);
    }
}
