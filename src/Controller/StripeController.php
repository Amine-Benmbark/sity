<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Panier;
use DateTimeImmutable;
use DateTimeInterface;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Service\Helpers;
use Stripe\StripeClient;
use App\services\AppHelpers;
use Stripe\Checkout\Session;
use App\services\CartService;
use App\Entity\DetailCommande;
use App\Entity\PanierProduit;
use Doctrine\ORM\Query\Expr\Math;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AppHelpers as ServiceAppHelpers;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StripeController extends AbstractController

{

    private string $bodyId;
    private $app;
    private $db;
    private $userInfo;
    private $session;
    private EntityManagerInterface $em;
    private UrlGeneratorInterface $generator;


    public function __construct( ManagerRegistry $doctrine, Helpers $app, RequestStack $requestStack, EntityManagerInterface $em, UrlGeneratorInterface $generator)

    {

        $this->app = $app;
        $this->bodyId = $app->getBodyId('ORDER_CONFIRMATION');
        $this->db = $doctrine->getManager();
        // $this->userInfo = $this->getUser();
        $this->em = $em;
        $this->generator = $generator;


        $this->session = $requestStack->getSession();
    

    }

    
    public function index(): RedirectResponse {
        $panier = $this->getUser()->getPanier();

        // $productStripe = [];

        // $order = $this->em->getRepository(Order::class)->findOneBy(['reference' => $reference]);

       

        // $panier = $this->getUser()->getPanier();
        if (null === $panier) {
            $articles = [];
        } else {
            $articles = $panier->getArticle();
        }
        // $lineItems = [];
        foreach ($articles as $article) {

            $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $article->getProduit(),
                            'images' => [$article->getProduit()->getImg()],
                        ],
                        'unit_amount' => $article->getProduit()->getPrix()*100, // Amount in cents (e.g., $10.00)
                    ],
                    'quantity' => $article->getQuantity(),
            ];
        }
        $total = 0;
        foreach ($lineItems as $item) {
            $total += $item['price_data']['unit_amount'] * $item['quantity'];
        }
        Stripe::setApiKey($_ENV["STRIPE_SECRET"]);

        $checkout_session = Session::create([
            'customer_email' => $this->getUser(),
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generator->generate('app_stripe_success', [
                'reference' => $article->getProduit(),
                'total' => $total // Passer le total dans les paramètres de redirection
            ], UrlGenerator::ABSOLUTE_URL),
            'cancel_url' => $this->generator->generate('app_stripe_fail', [
                'reference' => $article->getProduit(),
                'total' => $total
            ], UrlGeneratorInterface::ABSOLUTE_URL),

            ]);
            

            return new RedirectResponse($checkout_session->url);


    }

    public function stripeSuccess(Request $request, EntityManagerInterface $em): Response
    {
        $total = $request->query->get('total'); // Récupérer le total depuis les paramètres de redirection
       
        $user = $this->getUser();
        $panier = $this->getUser()->getPanier();
        
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setDate(new \DateTimeImmutable());
        $em->persist($commande);
        
        foreach ($panier->getArticle() as $panierProduit) {
            $produit = $panierProduit->getProduit();
            $quantite = $panierProduit->getQuantity();
            $prixUnitaire = $produit->getPrix();
            $img = $produit->getImg();
        
            $detail_commande = new DetailCommande();
            $detail_commande->setCommande($commande);
            $detail_commande->setName($produit->getName());
            $detail_commande->setQuantity($quantite);
            $detail_commande->setPrix($prixUnitaire);
            $detail_commande->setImg($img);
            $detail_commande->setTotal(); // Calculer le total pour chaque produit
        
            $em->persist($detail_commande);
        }
        
        $em->remove($panier);
        $em->flush();
        return $this->render('stripe/order_confirmation.html.twig', [
            'bodyId' => $this->bodyId,
            'userInfo' => $this->userInfo,
            'total' => $total,
        ]);
}
    
    public function paymentFailure(Request $request): Response {
        $total = $request->query->get('total'); // Récupérer le total depuis les paramètres de redirection
        // dd($total);
        return $this->render('stripe/payment_failure.html.twig', [
            'bodyId' => $this->bodyId,
            'total' => $total,
            'userInfo' => $this->userInfo,
        ]);
    }


}
