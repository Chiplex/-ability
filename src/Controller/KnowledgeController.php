<?php

namespace App\Controller;

use App\Entity\Ability;
use App\Entity\Knowledge;
use App\Form\AbilityType;
use App\Form\KnowledgeType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class KnowledgeController extends AbstractController
{
    /**
     * @Route("/knowledge", name="knowledge")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $knowledge = $em->getRepository()->findAll();

        return $this->render('knowledge/index.html.twig', [
            'controller_name' => 'KnowledgeController',
            'knowledge' => $knowledge
        ]);
    }

    /**
     * @Route("/knowledge/create", name="knowledge_create")
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $knowledge = new Knowledge();
        $form = $this->createForm(KnowledgeType::class, $knowledge);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $knowledge = $form->getData();

            $em->persist($knowledge);
            $em->flush();

            return $this->redirectToRoute('knowledge');
        }

        return $this->render('knowledge/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
