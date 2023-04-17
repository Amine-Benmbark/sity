<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosRealisationsController extends AbstractController
{
    #[Route('/nos/realisations', name: 'app_nos_realisations')]
    public function realisation(): Response
    {
        return $this->render('nos_realisations/nos_realisations.html.twig', [
            'controller_name' => 'NosRealisationsController',
        ]);
    }
}
