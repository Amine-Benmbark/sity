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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(EntityManagerInterface $em,SessionInterface $session): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setDate(new \DateTime('today'));
        //dd($commande);
        $panier = $this->getUser()->getPanier();
        // $panier = $em->find(Panier::class, $user);
        //  dd($panier);
        $produitsId = $em->getRepository(PanierProduit::class)->findBy(['panier'=>$panier]);
        //  dd($produitsId);
        $produits = $em->getRepository(Produit::class)->findAll();
       
        //  dd($produits);

        // if ($panier != null){ 
            if($panier !== null){
                foreach ($panier as $panierProduit) {
                     $produit = $panierProduit->getProduits();
                     $commande->addProduit($produit);}
                }
            else {
                return $this->redirectToRoute('app_panier');
            }

        //  dd($commande);
        $em->persist($commande);
        $em->flush();
        $total = $session->get('total');

        return $this->render('commande/index.html.twig', [
            'commande' => $commande,
            'panier' => $panier,
            'produitsId'=>$produitsId,
            'produits' => $produits,
            'total' => $total,
        ]);
    }
}
