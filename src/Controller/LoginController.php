<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

  class LoginController extends AbstractController
  {
      #[Route('/login', name: 'app_login')]
 
    public function connexion(AuthenticationUtils $authenticationUtils): Response    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();       
         return $this->render('login/index.html.twig', [
           
            'last_username' => $lastUsername,
            'error'         => $error,
            // 'img_carousel' => [
            //   '1' => 'assets/img_carousel/2338290.jpg',
            //   '2' => 'assets/img_carousel/2593044.jpg',
            //   '3' => 'assets/img_carousel/vitrine.jfif',
            //   '4' => 'assets/img_carousel/img4.jfif',
            //   '5' => 'assets/img_carousel/Image e-commerce mobile.jfif',
            //   '6' => 'assets/img_carousel/img6.jfif',
            //   ],
          ]);
      }
  }

// class LoginController extends AbstractController
// {
//     #[Route('/login', name: 'app_login')]
//     public function index(): Response
//     {
//         return $this->render('login/index.html.twig', [
//             'controller_name' => 'LoginController',
//         ]);
//     }
// }
