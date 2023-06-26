<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $panier = $this->getUser()->getPanier();
        if (null === $panier) {
            $articles = [];
        } else {
            $articles = $panier->getArticle();
        }

        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
            'articles' => $articles,
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
    public function delete(User $user, EntityManagerInterface $em, TokenStorageInterface $tokenStorage): Response {
      
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $tokenStorage = $tokenStorage;

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Supprimer l'utilisateur de la base de données
        $em->remove($user);
        $em->flush();

        // Déconnecter l'utilisateur après la suppression de son compte
        $tokenStorage->setToken(null);
        $this->get('session')->invalidate();

        // Ajoutez ici votre logique supplémentaire ou des redirections

        return $this->redirectToRoute('app_home');
    }
}
