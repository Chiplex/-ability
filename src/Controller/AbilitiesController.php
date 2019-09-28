<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ability;
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
        $user = new User();
        $user->setUsername('Fernando');
        $user->setEmail('fernando@mail.com');
        $user->setPassword('54321');
        $user->setIsActive(1);
        $user->setAuth(10);

        $em->persist($user);
        $em->flush();

        $ability = new Ability();
        $ability->setDescription('Ser extrovertido');
        $user = $em->getRepository(User::Class)->findOneBy(['username' => 'Alex']);
        $ability->setUser($user);

        $em->persist($ability);
        $em->flush();

        return $this->render('abilities/index.html.twig', [
            'data' => $ability,
        ]);
    }

    /**
     * @Route("/abilities/search", name="search_abilities")
     */
    public function search()
    {
        $em = $this->getDoctrine()->getManager();
        // Busca mediante el ID
        $ability1 = $em->getRepository(Ability::class)->find(1);
        // Busca segun el campo
        $ability2 = $em->getRepository(Ability::class)->findOneBy(['description' => 'Tocar Piano']);
        // Retorna dependiendo del criterio de busqueda
        $ability3 = $em->getRepository(Ability::class)->findBy(['user' => 2]);
        // Obtiene cada uno de los registros
        $ability4 = $em->getRepository(Ability::class)->findAll();

        return $this->render('abilities/index.html.twig', [
            'ability1' => $ability1,
            'ability2' => $ability2,
            'ability3' => $ability3,
            'ability4' => $ability4,
        ]);
    }
}
