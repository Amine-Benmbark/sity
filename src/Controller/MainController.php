<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MainController extends AbstractController
{
    // #[Route('/main', name: 'app_main')] -> plus besoin de la route car on l'a crée dans le fichier routes.yaml
    public function index(): RedirectResponse
    {
        // generation d'urls multiples
        // route relatives
        $getRoutePage = $this->generateUrl('app_get_route', ['param1' => 1, 'param2' => 'v']);

        // dump($getRoutePage);
        // exit();

        $absoluteGetRoutePage = $this->generateUrl('app_get_route', ['param1' => 1, 'param2' => 'v'], UrlGeneratorInterface::ABSOLUTE_URL);

        // dump($absoluteGetRoutePage);
        // exit();



        return $this->redirectToRoute('app_tirage_loto', [], 301);
        // [], 301 -> ici juste pour forcer un code 301
    }

    public function redirectTirageAleatoire() : RedirectResponse {
        return $this->redirectToRoute('app_tirage_aleatoire', [
            'nom_du_jeu' => 'keno',
            'num_boules_choisie' => 56,
            'num_boules_totales' => 208
        ]);
    }

    public function getRoute( Request $req, int $param1, string $param2) : response {
        


        $routeName = $req->attributes->get('_route');
        $allAttributes = $req->attributes->all();
        // dump($allAttributes);
        // exit();

        return new Response ('');
    }


}
