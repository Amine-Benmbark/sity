<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Helpers;
use Symfony\Component\Console\Helper\Helper;

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

    public function politiqueConfidentialite(Helpers $app): Response
    {
        return $this->render('static/politiqueConfidentialite.html.twig', [
            'bodyId' => $app->getBodyId('Confidentialite_PAGE'),
        ]);
    }

    public function cgv(Helpers $app): Response
    {
        return $this->render('static/cgv.html.twig',[
            'bodyId' => $app->getBodyId('CGV_PAGE'),
        ]);
    }
}
