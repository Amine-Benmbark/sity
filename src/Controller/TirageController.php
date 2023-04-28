<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TirageController extends AbstractController
{
    // #[Route('/tirage', name: 'app_tirage')]
    // public function index(): Response
    // {
    //     return $this->render('tirage/index.html.twig', [
    //         'controller_name' => 'TirageController',
    //     ]);
    // }

    public function tirageLoto() : Response {
        return new Response (
            "<html><body><h1>Tirage du Loto</h1><p>".
            $this->lanceTirage(6,50)."</p></body></html>"
        );
    }

    public function tirageKeno() : Response {
        return new Response (
            "<html><body><h1>Tirage du Loto</h1><p>".
            $this->lanceTirage(10,70)."</p></body></html>"
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
