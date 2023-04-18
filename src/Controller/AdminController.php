<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $user;
    private $entityManager;
    // public function __construct()
    // {
    //     $this->denyAccessUnlessGranted(('ROLE_ADMIN'));
    //     $this->user = $this->getUser();
    // }

    public function dashboard(ManagerRegistry $doctrine): Response
    {
        $user = $doctrine->getManager()->getRepository(User::class)->findAll();

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'user' => 'user',
        ]);
    }

    public function userManagement(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        return $this->render('admin/user-management.html.twig', []);
    }
}
