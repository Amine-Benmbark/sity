<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\User;
use App\Entity\PanierProduit;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(SessionInterface $session, ProduitRepository $produitRepository): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $panier = $this->getUser()->getPanier();
        if (null === $panier) {
            $articles = [];
        } else {
            $articles = $panier->getArticle();
        }
        $total = 0;
        foreach ($articles as $article) {
            $total += $article->getProduit()->getPrix() * $article->getQuantity();
        }
        $session->set('total', $total);

        // return new RedirectResponse($this->generateUrl('app_commande', ['total' => $total]));
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
        $this->denyAccessUnlessGranted('ROLE_USER');

        $produit = $em->getRepository(Produit::class)->find($id);
        $quantite = $request->request->get('quantite');
        // $date = $request->request->get('date');

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
    public function remmove(Produit $produit, EntityManagerInterface $em, int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $produit = $em->getRepository(Produit::class)->find($id);
        $user = $this->getUser();

        if (null !== $user->getPanier()) {
            $panier = $user->getPanier();
            $articles = $panier->getArticle();

            foreach ($articles as $article) {
                if ($article->getProduit()->getId() === $id) {
                    $quantite = $article->getQuantity() - 1;
                    if ($quantite > 0) {
                        $article->setQuantity($quantite);
                    } else {
                        $panier->removeArticle($article);
                        $em->remove($article);
                    }
                    break;
                }
            }

            $em->flush();
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/delete/panier/{id}', name: 'app_delete_panier')]
    public function delete(Produit $produit, EntityManagerInterface $em, int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $produit = $em->getRepository(Produit::class)->find($id);
        $user = $this->getUser();

        if (null !== $user->getPanier()) {
            $panier = $user->getPanier();
            $articles = $panier->getArticle();

            foreach ($articles as $article) {
                if ($article->getProduit()->getId() === $id) {
                    $panier->removeArticle($article);
                    $article->setPanier(null); // Réinitialise la relation avec le panier
                    $em->remove($article);
                    break;
                }
            }

            $em->flush();
        }

        return $this->redirectToRoute('app_panier');
    }


    #[Route('/delete_all', name: 'app_delete_all_panier')]
    public function deleteall(EntityManagerInterface $em)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        if (null !== $user->getPanier()) {
            $panier = $user->getPanier();
            $articles = $panier->getArticle();

            foreach ($articles as $article) {
                $panier->removeArticle($article);
                $em->remove($article);
            }

            $em->flush();
        }

        return $this->redirectToRoute('app_panier');
    }
}
