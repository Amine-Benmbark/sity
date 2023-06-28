<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\FormTypeInterface;
use App\Form\EditProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
   
    public function dashboard(): Response
    {
        return $this->render('user/dashboard.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    // #[Route('/v', name: 'app_v', methods: ['GET', 'POST'])]
    // public function edit(Request $request, EditProfilType $user, UserRepository $userRepository): Response
    // {
    //     $form = $this->createForm(EditProfilType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $userRepository->save($user, true);

    //         return $this->redirectToRoute('app_profil', []);
    //     }

    //     return $this->renderForm('profil/profil.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }

    
#[Route('/profil/editprofil', name: 'users_profil_modifier')]
public function editProfil(HttpFoundationRequest $request,  UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine)
{
    $user = $this->getUser();
    $form = $this->createForm(EditProfilType::class, $user);

    $form->handleRequest($request);
// on cree un objet App\entity user pour la
// méthode hashPassword ci dessous uniquement
    $usr = new User;


    if ($form->isSubmitted() && $form->isValid()) {
        $doctrine->getManager()->getRepository(User::class)->upgradePassword(
            $user,
            $userPasswordHasher->hashPassword(
                $usr,
                $form->get('password')->getData()
            )
        );

        $em = $doctrine->getManager();
        // foreach ($form['email']->getData() as $utilisateur) {
        //     $user->$this->getUser()->add($utilisateur);
        // }
        $em->persist($user);
        $em->flush();

        $this->addFlash('message', 'Profil mis à jour');
        return $this->redirectToRoute('app_profil');
    }
    $user = $this->getUser();
    return $this->render('profil/editprofil.html.twig', [
        'form' => $form->createView(),
    ]);
    }
}