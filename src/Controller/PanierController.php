<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\User;
use App\Entity\PanierProduit;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(SessionInterface $session, ProduitRepository $produitRepository): Response
    {

        $panier = $this->getUser()->getPanier();
        if (null === $panier) {
            $articles = [];
        } else {
            $articles = $panier->getArticle();
        }
        $total = 0;
        // foreach($panier as $id => $quantite){
        //     $produit = $produitRepository->find($id);
        //     $total += $produit->getPrix() * $quantite;
        // }
    //     $liste = $panier->getArticle();
    //     foreach ($liste as $articles){
    //     {
    //         $total += $panier * $articles ;
    //     }
    //     // return $total;
    // }

        return $this->render(
            'panier/panier.html.twig',
            [
                'articles' => $articles,
                'total' => $total,
            ]
        );
    }

    #[Route('/add/panier/{id}', name: 'app_add_panier')]
    public function add(Produit $produit, Request $request, EntityManagerInterface $em, int $id)
    {
        $produit = $em->getRepository(Produit::class)->find($id);
        $quantite = $request->request->get('quantite');

        if (null == $quantite) {
            $quantite = 1;
        }
        $user = $this->getUser();
        if (null !== $user->getPanier()) {
            $panier = $user->getPanier();
        } else {
            $panier = new Panier;
            $panier->setUser($user);
            $panier->setCreatedAt(new \DateTimeImmutable());
        }

        $found = false;
        if (!empty($panier->getArticle())) {
            $articles = $panier->getArticle();
          //  $prix = $panier->getPrix();
            $total = 0;
            foreach ($articles as $article) {
                if ($article->getProduit()->getId() === $id) {
                    $found = true;
                    $article->setQuantity((int)$article->getQuantity() + $quantite);
                    $total += $total * $article->getQuantity(); 
                }
            }
        }
        if (!$found) {
            $lignePanier = new PanierProduit;
            $lignePanier->setQuantity($quantite);
            $lignePanier->setProduit($produit);
            $panier->addArticle($lignePanier);
            $em->persist($lignePanier);
        }

        $panier->setUpdatedAt(new \DateTimeImmutable());

        $em->persist($panier);
        $em->flush();

        // return $this->render('panier/panier.html.twig',compact("dataPanier", "total"));
        return $this->redirectToRoute('app_panier');
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
    }

    #[Route('/delete_all', name: 'app_delete_all_panier')]
    public function deleteAll(SessionInterface $session){

       $session->set('panier', []);

        return $this->redirectToRoute('app_panier');
    }
}
