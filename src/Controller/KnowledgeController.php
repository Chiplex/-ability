<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ability;
use App\Entity\Knowledge;
use App\Form\AbilityType;
use App\Form\KnowledgeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class KnowledgeController extends AbstractController
{
    /**
     * @Route("/knowledge", name="knowledge")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $knowledge = $em->getRepository(Knowledge::class)->findAll();

        return $this->render('knowledge/index.html.twig', [
            'controller_name' => 'KnowledgeController',
            'knowledges' => $knowledge
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

        return $this->render('knowledge/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/knowledge/update/{knowledge}", name="knowledge_update")
     */
    public function update(Request $request, Knowledge $knowledge)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder($knowledge)
            ->add('mencion')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email'
            ])
            ->add('Enviar', SubmitType::class)
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $knowledge = $form->getData();
            $em->persist($knowledge);
            $em->flush();

            return $this->redirectToRoute('knowledge');
        }

        return $this->render('knowledge/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/knowledge/delete/{knowledge}", name="knowledge_delete")
     */
    public function delete(Knowledge $knowledge)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($knowledge);
        $em->flush();

        return $this->redirectToRoute('knowledge');
    }
}
