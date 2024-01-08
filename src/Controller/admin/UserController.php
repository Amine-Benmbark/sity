<?php


namespace App\Controller\admin;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Service\Helpers;
use App\Entity\Categorie;
use App\Form\ProduitFormType;
use App\Service\FileUploader;
use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManager;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as ControllerAbstractController;

#[Route('/admin/user', name:'admin_user')]
class UserController extends ControllerAbstractController
{
    private $manager;
    public function __construct(Helpers $app, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->manager = $doctrine->getManager();

    }

    #[Route('/', name:'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $user = $this->manager->getRepository(User::class)->findAll();
        // $categorie = $this->manager->getRepository(Categorie::class)->findAll();
        $commande = $this->manager->getRepository(Commande::class)->findAll();
        // dump($commande);
        return $this->render('admin/user/user_list.html.twig', [
            'user' => $user,
            'commande' => $commande,
            // 'categorie' => $categorie,
        ]);
    }

    #[Route('/users_commande/{id}', name: 'users_commande')]
    public function users_commande(EntityManagerInterface $em, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
        $user = $this->manager->getRepository(User::class)->find($id);


        // $id = $request->attributes->get('id');
        $commande = $user->getCommande();
        $detailcommande = [];

        foreach ($commande as $detail){
            if($em->getRepository(DetailCommande::class)->findBy(['commande' => $detail->getId()])){
                $detailcommande[] = $em->getRepository(DetailCommande::class)->findBy(['commande' => $detail->getId()]);
            }
        }

        $articles = [];
    
        if ($user !== null) {
            $panier = $user->getPanier();
            if ($panier !== null) {
                $articles = $panier->getArticle();
            }
        }
    
        return $this->render('admin/user/users_commande.html.twig', [
            'user' => $user,
            'articles' => $articles,
            'commande' => $commande,
            'detailcommande' => $detailcommande,
        ]);
    }


    #[Route('/ajout', name:'add')]
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $formuser = $this->createForm(RegistrationFormType::class, $user);

        $formuser->handleRequest($request);
        // dd($formproduit);
        if($formuser->isSubmitted() && $formuser->isValid()){
            $email = $user->getEmail();
            $user->setEmail($email);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User ajouté');

            return $this->redirectToRoute('admin_useradd');
        }

        return $this->render('admin/user/add_user.html.twig',[
            'formuser' => $formuser->createView(),
        ]);
        // return $this->$this->renderForm('admin/produit/add.html.twig', compact('formproduit'));
    }


    
    #[Route('/edition_user/{id}', name:'edit_user')]
    public function edit_user(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // $user = $this->getUser();
        // $form = $this->createForm(RegistrationFormType::class, $user);
        // $form->handleRequest($request);

        $formuser = $this->createForm(RegistrationFormType::class, $user);

        $formuser->handleRequest($request);
        // dd($formproduit);
        if($formuser->isSubmitted() && $formuser->isValid()){
            $email = $user->getEmail();
            $user->setEmail($email);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $formuser->get('password')->getData()
                )
            );
            
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User modifié');

            return $this->redirectToRoute('admin_useradd');
        }

        return $this->render('admin/user/edit.html.twig',[
            'formuser' => $formuser->createView(),
        ]);
    }

    #[Route('/supp_user/{id}', name:'delete', methods:['DELETE'])]
    public function delete(User $user,  EntityManagerInterface $em): Response
    {
       
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $em->remove($user);
        $em->flush();

       $this->addFlash('success', 'Utilisateur supprimé');

       return $this->redirectToRoute('app_users');
    }
}