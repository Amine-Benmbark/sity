<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersDashboardController extends AbstractController
{
    #[Route('/users/dashboard', name: 'app_users_dashboard')]
    public function index(): Response
    {
        return $this->render('users_dashboard/users_dashboard.html.twig', [
            'controller_name' => 'UsersDashboardController',
        ]);
    }
}
