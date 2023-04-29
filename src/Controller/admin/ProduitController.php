<?php


namespace App\Controller\admin;

use App\Entity\Produit;
use App\Form\ProduitFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as ControllerAbstractController;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/produit', name:'admin_produit')]
class ProduitController extends ControllerAbstractController
{
    #[Route('/', name:'index')]
    public function index(): Response
    {
        return $this->render('admin/produit/produit.html.twig');
    }

    #[Route('/ajout', name:'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $produit = new Produit();

        $formproduit = $this->createForm(ProduitFormType::class, $produit);

        $formproduit->handleRequest($request);
        // dd($formproduit);
        if($formproduit->isSubmitted() && $formproduit->isValid()){
            $prix = $produit->getPrix() * 100;
            $produit->setPrix($prix);

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
    public function edit(Produit $produit, Request $request, EntityManagerInterface $em): Response
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