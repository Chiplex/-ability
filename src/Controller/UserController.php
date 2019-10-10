<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vete de aqui no puedes entrar');

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $user = $this->getUser();

        return $this->render('user/user.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/show/{user}", name="user_show")
     */
    public function show(User $user, Request $request, AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }
    }

    /**
     * @Route("/user/update/{user}", name="user_update")
     */
    public function update(User $user, 
        Request $request, 
        AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }

        return $this->render('base.html.twig');
    }

    /**
     * @Route("/user/delete/{user}", name="user_delete")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete(User $user, Request $request)
    {
        dump($user);
    }
}
