<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurMesureController extends AbstractController
{
    #[Route('/sur/mesure', name: 'app_sur_mesure')]
    public function sur_mesure(): Response
    {
        return $this->render('sur_mesure/index.html.twig', [
            'controller_name' => 'SurMesureController',
        ]);
    }
}
