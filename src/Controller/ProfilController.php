<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil( EntityManagerInterface $em, Request $request): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        // $id = $request->attributes->get('id');
        $commande = $user->getCommande();
        $detailcommande = [];

        foreach ($commande as $detail){
            if($em->getRepository(DetailCommande::class)->findBy(['commande' => $detail->getId()])){
                $detailcommande[] = $em->getRepository(DetailCommande::class)->findBy(['commande' => $detail->getId()]);
            }
        }
        // dd($detailcommande);


        $panier = $this->getUser()->getPanier();
        if (null === $panier) {
            $articles = [];
        } else {
            $articles = $panier->getArticle();
        }

        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
            'articles' => $articles,
            'commande' => $commande,
            'detailcommande' => $detailcommande,
        ]);
    }

    public function updateAction(EntityManagerInterface $entityManager, $email) {

    // $entityManager = $this->getDoctrine()->getManager();
    $user = $entityManager->getRepository(User::class)->find($email);

    if (!$user) {
        throw $this->createNotFoundException(
            'Pas de produit ayant un id :  '.$email
        );
    }

    $email->setDescription(' Ma nouvelle description !!');
    $entityManager->flush();

    return new Response('Produit modifié avec succès  ');
    }

    
    #[Route('/supp_profil/{id}', name:'users_profil_delete')]
    public function delete(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, SessionInterface $session): Response
    {
        // Votre logique de suppression d'utilisateur ici

        // Récupérer l'utilisateur actuel
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Supprimer l'utilisateur de la base de données
        $em->remove($user);
        $em->flush();

        // Déconnecter l'utilisateur après la suppression de son compte
        $tokenStorage->setToken(null);
        $session->invalidate();

        // Rediriger l'utilisateur vers la page de connexion
        return $this->redirectToRoute('app_login');
    }
}
