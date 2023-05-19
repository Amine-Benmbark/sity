<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\PanierProduit;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $commande = new Commande();
        $commande->setUser($user);
        // $panier = $user->getPanier();
        $panier = $em->find(Panier::class, $user->getId());
// dd( $panier);
        $produitsId = $em->getRepository(PanierProduit::class)->findBy(['panier'=>$panier]);
        // dd($produits);
        $produits =$em->getRepository(Produit::class)->findAll();
       
        // dd($produitsId);
        foreach ($panier->getProduits() as $panierProduit) {
            $produit = $panierProduit->getProduits();
            $commande->addProduit($produit);
        }
        $em->persist($commande);
        $em->flush();
        // dd($commande);
        // dd($commande->getProduits());
        return $this->render('commande/index.html.twig', [
            'commande' => $commande,
            'panier' => $panier,
            'produitsId'=>$produitsId,
            'produits' => $produits,
            // 'produits' => $commande->getProduit(),
        ]);
    }
}
