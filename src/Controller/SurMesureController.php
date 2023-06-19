<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Service\Helpers;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurMesureController extends AbstractController
{
    private $manager;
    public function __construct(Helpers $app, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->manager = $doctrine->getManager();

    }

    #[Route('/sur/mesure', name: 'app_sur_mesure')]
    public function surMesure(): Response
    {
        // $categorieId = 4;
        $produit = $this->manager->getRepository(Produit::class)->findAll();
        $categorie = $this->manager->getRepository(Categorie::class)->findAll();

        return $this->render('sur_mesure/index.html.twig', [
            'controller_name' => 'VitrineController',
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }
}
