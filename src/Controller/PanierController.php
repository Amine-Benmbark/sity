<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(SessionInterface $session, ProduitRepository $produitRepository): Response
    {

        $panier = $session->get("panier", []);

        //fabriquer les données
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $produit = $produitRepository->find($id);
            $dataPanier[] = [
                "produit" => $produit,
                "quantite" => $quantite,
            ];
            $total += $produit->getPrix() * $quantite;
        }

        return $this->render('panier/panier.html.twig',compact("dataPanier", "total")
        //  [    'controller_name' => 'PanierController',
        // ]
    );
    }

    #[Route('/add/panier/{id}', name: 'app_add_panier')]
    public function add(Produit $produit, SessionInterface $session){
        // $session->set("panier", 8);
        // dd($session->get('panier'));
        //recuperer le panier actuel

        $panier = $session->get('panier', []);
        $id = $produit->getId();

        if(!empty($panier[$id])){
            $panier[$id] ++;
        }
        else{
            // $panier = [];
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('app_panier');

        // dd($session);
    }

    #[Route('/remove/panier/{id}', name: 'app_remove_panier')]
    public function remove(Produit $produit, SessionInterface $session){
        // $session->set("panier", 8);
        // dd($session->get('panier'));
        //recuperer le panier actuel

        $panier = $session->get('panier', []);
        $id = $produit->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id] --;
            }
            else{
                unset($panier[$id]);
            }
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('app_panier');

        // dd($session);
    }

    #[Route('/delete/panier/{id}', name: 'app_delete_panier')]
    public function delete(Produit $produit, SessionInterface $session){

        $panier = $session->get('panier', []);
        $id = $produit->getId();

        if(!empty($panier[$id])){
                unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('app_panier');

        // dd($session);
    }

    #[Route('/delete_all', name: 'app_delete_all_panier')]
    public function deleteAll(SessionInterface $session){

       $session->set('panier', []);

        return $this->redirectToRoute('app_panier');
    }
}
