<?php

namespace App\Controller;

use App\Service\AppHelpers;
use App\Controller\Produit;
use App\Entity\Categorie as EntityCategorie;
use App\Entity\Produit as EntityProduit;
use App\Service\Helpers;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    private $app;
    private $userinfo;
    private $manager;

    public function __construct(AppHelpers $apps, Helpers $app, ManagerRegistry $doctrine, EntityManagerInterface $entityManager){
        $this->app = $app;
        $this->userinfo = $apps->getUser();
        $this->manager = $doctrine->getManager();
    }
    // #[Route('/home', name: 'app_home')]
    public function index(Helpers $app): Response
    {
        // dump($this->app->getUser()); exit();
        $categorie = $this->manager->getRepository(EntityCategorie::class)->findAll();
        
        $produit = $this->manager->getRepository(EntityProduit::class)->findAll();
        return $this->render('home/index.html.twig', [
           'bodyId' => $app->getBodyId('HOME_PAGE'),
           'userinfo' => $this->userinfo,
           'img_carousel' => [
            '1' => 'assets/img_carousel/2338290.jpg',
            '2' => 'assets/img_carousel/2593044.jpg',
            '3' => 'assets/img_carousel/vitrine.jfif',
            '4' => 'assets/img_carousel/img4.jfif',
            '5' => 'assets/img_carousel/Image e-commerce mobile.jfif',
            '6' => 'assets/img_carousel/img6.jfif',
            ],
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }
}
