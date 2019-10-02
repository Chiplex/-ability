<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ability;
use App\Form\AbilityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbilitiesController extends AbstractController
{
    /**
     * @Route("/abilities", name="abilities")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find();

        $ability = new Ability();
        $ability->setDescription('Reposteria');
        $ability->setUser($user);

        $em->persist($user);
        $em->persist($ability);
        $em->flush();

        return $this->render('abilities/index.html.twig', [
            'data' => $user,
        ]);

    //     $em = $this->getDoctrine()->getManager();
    //     $user = new User();
    //     $user->setUsername('Fernando');
    //     $user->setEmail('fernando@mail.com');
    //     $user->setPassword('54321');
    //     $user->setIsActive(1);
    //     $user->setAuth(10);

    //     $em->persist($user);
    //     $em->flush();

    //     $ability = new Ability();
    //     $ability->setDescription('Ser extrovertido');
    //     $user = $em->getRepository(User::Class)->findOneBy(['username' => 'Alex']);
    //     $ability->setUser($user);

    //     $em->persist($ability);
    //     $em->flush();

    //     return $this->render('abilities/index.html.twig', [
    //         'data' => $ability,
    //     ]);
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
     * @Route("/abilities/store", name="search_abilities")
     */
    // public function store(Request $request)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $ability = new Ability();

    //     $form = $this->createForm(AbilityType::class, $ability);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $ability = $form->getData();

    //         $em->persist($ability);
    //         $em->flush();

    //         return $this->redirectToRoute('abilities');
    //     }

    //     return $this->render('abilities/create.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }
}
