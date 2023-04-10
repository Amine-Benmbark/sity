<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Helpers;

class StaticController extends AbstractController
{
    // public function inscription(Helpers $app): Response
    // {
    //     return $this->render('static/inscription.html.twig', [
    //         'bodyId' => $app->getBodyId('INSCRIPTION_PAGE'),
    //     ]);
    // }

    // public function connexion(Helpers $app): Response
    // {
    //     return $this->render('static/connexion.html.twig', [
    //         'bodyId' => $app->getBodyId('CONNEXION_PAGE'),
    //     ]);
    // }
    
    public function mentionsLegales(Helpers $app): Response
    {
        return $this->render('static/mentions.html.twig', [
            'bodyId' => $app->getBodyId('LEGAL_PAGE'),
        ]);
    }

    public function politiqueCookies(Helpers $app): Response
    {
        return $this->render('static/cookies.html.twig', [
            'bodyId' => $app->getBodyId('COOKIE_PAGE'),
        ]);
    }
}
