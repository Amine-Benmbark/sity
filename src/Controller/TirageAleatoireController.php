<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TirageAleatoireController extends AbstractController
{
    // #[Route('/tirage/aleatoire', name: 'app_tirage_aleatoire')]
    // public function index(): Response
    // {
    //     return $this->render('tirage_aleatoire/index.html.twig', [
    //         'controller_name' => 'TirageAleatoireController',
    //     ]);
    // }

    public function tirage(string $nom_du_jeu, int $num_boules_choisie, int $num_boules_totales) : Response {
        $tirage = $this->lanceTirage($num_boules_choisie, $num_boules_totales);
        return new Response(
            "<html>
                <head></head>
                <body>
                    <h1>$nom_du_jeu</h1>
                    <p>$num_boules_choisie sur $num_boules_totales</p>
                    <p>$tirage</p>
                </body>
            </html>"
        );
    }

    private function lanceTirage(int $n_num, int $n_tot_num) : string {
        $str_tirage = "";
        $array_tirage = [];
        $numeros = range(1, $n_tot_num);
        shuffle($numeros);
        $array_tirage = array_slice($numeros, 0, $n_num);
        $str_tirage = "Tirage : " . implode("..", $array_tirage);
        //implode -> transforme un array en string
        //explode -> transforme un string en array
        return $str_tirage;
    }
}
