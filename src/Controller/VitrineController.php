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

class VitrineController extends AbstractController
{

    private $manager;
    public function __construct(Helpers $app, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->manager = $doctrine->getManager();

    }

    #[Route('/vitrine', name: 'app_vitrine')]
    public function vitrine(): Response
    {
        $produit = $this->manager->getRepository(Produit::class)->findAll();
        $categorie = $this->manager->getRepository(Categorie::class)->findAll();
        return $this->render('vitrine/index.html.twig', [
            'controller_name' => 'VitrineController',
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }
}
