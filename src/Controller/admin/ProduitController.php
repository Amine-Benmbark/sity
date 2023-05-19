<?php


namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\ProduitFormType;
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

#[Route('/admin/produit', name:'admin_produit')]
class ProduitController extends ControllerAbstractController
{
    private $manager;
    public function __construct(Helpers $app, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->manager = $doctrine->getManager();

    }

    #[Route('/', name:'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $produit = $this->manager->getRepository(Produit::class)->findAll();
        $categorie = $this->manager->getRepository(Categorie::class)->findAll();

        return $this->render('admin/produit/produit.html.twig', [
            'produit' => $produit,
            'categorie' => $categorie,
        ]);
    }



    #[Route('/ajout', name:'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $produit = new Produit();

        $formproduit = $this->createForm(ProduitFormType::class, $produit);

        $formproduit->handleRequest($request);
        // dd($formproduit);
        if($formproduit->isSubmitted() && $formproduit->isValid()){
            $prix = $produit->getPrix() * 100;
            $produit->setPrix($prix);

            $imgFile = $formproduit->get('img')->getData();
            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imgFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                    // $imgFile = $formproduit->get('img')->getData();
                    // if ($imgFile) {
                    //     $imgFileName = $fileUploader->upload($imgFile);
                    //     $produit->setimg($imgFileName);
                    // }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $produit->setImg($newFilename);
            }

            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté');

            return $this->redirectToRoute('admin_produitadd');
        }

        return $this->render('admin/produit/add.html.twig',[
            'formproduit' => $formproduit->createView(),
        ]);
        // return $this->$this->renderForm('admin/produit/add.html.twig', compact('formproduit'));
    }


    
    #[Route('/edition/{id}', name:'edit')]
    public function edit(Produit $produit, Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $prix = $produit->getPrix() / 100;
        $produit->setPrix($prix);

        $formproduit = $this->createForm(ProduitFormType::class, $produit);

        $formproduit->handleRequest($request);
        // dd($formproduit);
        if($formproduit->isSubmitted() && $formproduit->isValid()){
            $prix = $produit->getPrix() * 100;
            $produit->setPrix($prix);
            $imgFile = $formproduit->get('img')->getData();
            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imgFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $produit->setImg($newFilename);
                    }

            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté');

            return $this->redirectToRoute('admin_produitadd');
        }

        return $this->render('admin/produit/edit.html.twig',[
            'formproduit' => $formproduit->createView(),
        ]);
    }

    #[Route('/supp/{id}', name:'delete')]
    public function delete(Produit $produit): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/produit/produit.html.twig');
    }
}