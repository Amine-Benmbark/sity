<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Helpers;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class ECommerceController extends AbstractController
{
    private $manager;
    public function __construct(Helpers $app, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->manager = $doctrine->getManager();

    }

    #[Route('/ecommerce', name: 'app_ecommerce')]
    public function ecommerce(): Response
    {
        $produit = $this->manager->getRepository(Produit::class)->findAll();
        $categorie = $this->manager->getRepository(Categorie::class)->findAll();

        return $this->render('e-commerce/ecommerce.html.twig', [
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }
}
