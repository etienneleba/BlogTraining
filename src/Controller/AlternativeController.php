<?php

namespace App\Controller;

use App\Entity\Alternative;
use App\Form\AlternativeType;
use App\Form\FilterType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AlternativeController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/alternatives", name="alternatives")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(FilterType::class);

        $typeId = null;
        $contentTypeId = null;

        $repo = $this->getDoctrine()->getRepository(Alternative::class);

        $form->handleRequest($request);

        $criteria = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // if the field type is set, we add the value to the criteria array
            $formData['type'] ? $criteria['type'] = $form->getData()['type']->getId() : null;

            // if the field contentType is set, we add the value to the criteria array
            $formData['contentType'] ? $criteria['contentType'] = $form->getData()['contentType']->getId() : null;
        }

        $alternatives = $repo->findBy($criteria, ['created_at' => 'DESC']);

        return $this->render('alternative/index.html.twig', [
            'alternatives' => $alternatives,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/alternative/new", name="new_alternative")
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        $alternative = (new Alternative())
            ->setUser($this->getUser())
        ;

        $form = $this->createForm(AlternativeType::class, $alternative)->add('create', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alternative = $form->getData();

            $em->persist($alternative);

            $em->flush();

            $this->addFlash('success', 'New alternative Created!');

            return $this->redirectToRoute('profile');
        }

        return $this->render('alternative/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/alternative/edit/{id}", name="edit_alternative")
     */
    public function edit(Alternative $alternative, Request $request, EntityManagerInterface $em)
    {
        if ($this->getUser()->getId() !== $alternative->getUser()->getId()) {
            $this->addFlash('danger', 'You\'re not authorized to edit this alternative');

            return $this->redirectToRoute('view_alternative', [
                'id' => $alternative->getId(),
            ]);
        }

        $form = $this->createForm(AlternativeType::class, $alternative)->add('Save', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alternative = $form->getData();

            $em->flush();

            $this->addFlash('success', 'Alternative updated !');

            return $this->redirectToRoute('profile');
        }

        return $this->render('alternative/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/alternative/view/{id}", name="view_alternative")
     */
    public function view(Alternative $alternative)
    {
        return $this->render('alternative/view.html.twig', [
            'alternative' => $alternative,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/alternative/delete/{id}", name="delete_alternative")
     */
    public function delete(Alternative $alternative, EntityManagerInterface $em)
    {
        if ($this->getUser()->getId() !== $alternative->getUser()->getId()) {
            $this->addFlash('danger', 'You\'re not authorized to delete this alternative');

            return $this->redirectToRoute('view_alternative', [
                'id' => $alternative->getId(),
            ]);
        }

        $em->remove($alternative);

        $em->flush();

        return $this->redirectToRoute('profile');
    }
}
