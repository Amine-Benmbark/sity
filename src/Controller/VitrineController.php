<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VitrineController extends AbstractController
{
    #[Route('/vitrine', name: 'app_vitrine')]
    public function vitrine(): Response
    {
        return $this->render('vitrine/index.html.twig', [
            'controller_name' => 'VitrineController',
            'vitrine_carousel' => [
                '1' => 'assets/vitrine_img/vitrine_1.jpg',
                '2' => 'assets/vitrine_img/vitrine_2.jpg',
                '3' => 'assets/vitrine_img/vitrine_3.jpg',
                '4' => 'assets/vitrine_img/vitrine_4.jpg',                
                '5' => 'assets/vitrine_img/vitrine_5.jpg',
                '6' => 'assets/vitrine_img/vitrine_6.png',
            ],
        ]);
    }
}
