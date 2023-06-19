<?php


namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Form\CategorieFormType;
use App\Service\FileUploader;
use App\Service\Helpers;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as ControllerAbstractController;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categorie', name:'admin_categorie')]
class CategorieController extends ControllerAbstractController
{
    private $manager;
    public function __construct(Helpers $app, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->manager = $doctrine->getManager();

    }

    #[Route('/', name:'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $categorie = $this->manager->getRepository(categorie::class)->findAll();
        $categorie = $this->manager->getRepository(Categorie::class)->findAll();

        return $this->render('admin/categorie/categorie.html.twig', [
            'categorie' => $categorie,
            'categorie' => $categorie,
        ]);
    }


    #[Route('/ajout', name:'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $categorie = new categorie();

        $formcategorie = $this->createForm(CategorieFormType::class, $categorie);

        $formcategorie->handleRequest($request);
        // dd($formcategorie);
        if($formcategorie->isSubmitted() && $formcategorie->isValid()){
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('app_categorie');    
        }
            $this->addFlash('success', 'categorie ajouté');
        

        return $this->render('admin/categorie/add.html.twig',[
            'formcategorie' => $formcategorie->createView(),
        ]);
        // return $this->$this->renderForm('admin/categorie/add.html.twig', compact('formcategorie'));
    }


    
    #[Route('/edition/{id}', name:'edit')]
    public function edit(categorie $categorie, Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $formcategorie = $this->createForm(CategorieFormType::class, $categorie);

        $formcategorie->handleRequest($request);
        if($formcategorie->isSubmitted() && $formcategorie->isValid()){
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('app_categorie');    
        }

            $this->addFlash('success', 'categorie ajouté');

        return $this->render('admin/categorie/edit.html.twig',[
            'formcategorie' => $formcategorie->createView(),
        ]);
    }

    #[Route('/supp/{id}', name:'delete')]
    public function delete(Categorie $categorie, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
         $em->remove($categorie);
         $em->flush();

        $this->addFlash('success', 'Categorie supprimé');

        return $this->redirectToRoute('app_categorie');
    }
}