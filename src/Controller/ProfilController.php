<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
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
}
