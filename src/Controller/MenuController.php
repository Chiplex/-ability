<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index()
    {
        $menu = array(
            array(
                'titulo' => 'Habilidades',
                'link' => 'abilities'
            ),
            array(
                'titulo' => 'Conocimiento',
                'link' => 'knowledge'
            )
        );
        return $this->render('menu/index.html.twig', [
            'aside_menus' => $menu,
        
        ]);
    }
}
