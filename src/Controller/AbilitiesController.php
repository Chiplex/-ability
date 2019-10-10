<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ability;
use App\Form\AbilityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbilitiesController extends AbstractController
{
    /**
     * @Route("/ability", name="abilities")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $ability = $em->getRepository(Ability::class)->findAll();


        return $this->render('abilities/index.html.twig', [
            'abilities' => $ability ,
        ]);
    }

    /**
     * @Route("/abilities/search", name="search_abilities")
     */
    public function search()
    {
        $em = $this->getDoctrine()->getManager();
        // Busca mediante el ID
        $ability1 = $em->getRepository(Ability::class)->find(2);
        // Buscar mediante findOneBy
        $ability2 = $em->getRepository(Ability::class)->findOneBy([
            'description' => 'Reir como loco'
        ]);
        // Buscar mediante FindBy
        $ability3 = $em->getRepository(Ability::class)->findBy([
            'user' => '3'
        ]);
        // Buscar todos mediante FindAll
        $ability4 = $em->getRepository(Ability::class)->findAll();
        // Buscar todos mediante consulta personalizada
        $ability5 = $em->getRepository(Ability::class)->BuscarAbilityPorUser();
        // Buscar todos mediante consulta personalizada con parametros
        $ability6 = $em->getRepository(Ability::class)->BuscarAbilityPorID(3);

        return $this->render('abilities/search.html.twig', [
            'ability1' => $ability1,
            'ability2' => $ability2,
            'ability3' => $ability3,
            'ability4' => $ability4,
            'ability5' => $ability5,
            'ability6' => $ability6,

        ]);
    }

    /**
     * @Route("/ability/create", name="ability_create")
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ability = new Ability();

        $form = $this->createForm(AbilityType::class, $ability);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ability = $form->getData();

            $em->persist($ability);
            $em->flush();

            return $this->redirectToRoute('abilities');
        }

        return $this->render('abilities/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/abilities/update/{ability}", name="ability_update")
     */
    public function update(Request $request, Ability $ability)
    {
        $form = $this->createFormBuilder($ability)
            ->add('description')
            ->add('history', TextareaType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email'
            ])
            ->add('enviar', SubmitType::class)
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ability = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($ability);
            $em->flush();

            return $this->redirectToRoute('abilities');
        }
        return $this->render('abilities/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/abilities/delete/{ability}", name="ability_delete")
     */
    public function delete()
    {
        # code...
    }

    /**
     * @Route("/abilities/show/{ability}", name="ability_show")
     */
    public function show(Ability $ability)
    {
        return $this->render('abilities/show.html.twig', [
            'ability' => $ability
        ]);
    }
}
