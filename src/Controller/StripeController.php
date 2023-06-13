<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Stripe;

use App\Service\AppHelpers;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class StripeController extends AbstractController
{
    private string $bodyId;
    private $app;
    private $db;
    private $userInfo;
    private $cartCount;
    private $session;

    public function __construct(Security $security, ManagerRegistry $doctrine,  AppHelpers $app, RequestStack $requestStack) {
        $this->app = $app;
        // $this->bodyId = $app->getBodyId('ORDER_CONFIRMATION');
        $this->db = $doctrine->getManager();
        $this->userInfo = $app->getUser();
        $this->session = $requestStack->getSession();

        // on simule le montant obtenu depuis la page de commande:

        $this->session->set('orderTotal', 52.6);
    }

    public function index(Session $session): Response {
        $total = $session->get('total');

        return $this->render('stripe/index.html.twig', [
            'clef_stripe' => $_ENV["STRIPE_KEY"],
            // 'bodyId' => $this->bodyId,
            'cartCount' => $this->cartCount,
            'userInfo' => $this->userInfo,
            'orderTotal' => $this->session->get('orderTotal'),
            'total' => $total,
        ]);
    }

    public function createCharge(Request $request){
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        try {
            Stripe\Charge::create([
                "amount" => $this->session->get('orderTotal') * 100,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'),
                "description" => "Payment Test"
            ]);
        } catch (\Exception $e) {
            return $this->redirectToRoute('app_stripe_fail', [
                'error' => $e->getMessage(),
            ], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_stripe_success', [], Response::HTTP_SEE_OTHER);
    }

    public function orderConfirmation(Session $session): Response {

        $total = $session->get('total');

        return $this->render('stripe/order_confirmation.html.twig', [
            'cartCount' => $this->cartCount,
            'userInfo' => $this->userInfo,
            'total' => $total,
        ]);

    }


    public function paymentFailure(Request $request, Session $session): Response {

        $total = $session->get('total');
        $error = $request->get('error');

        return $this->render('stripe/payment_failure.html.twig', [
            'cartCount' => $this->cartCount,
            'userInfo' => $this->userInfo,
            'error' => $error,
            'total' => $total,
        ]);
    }
}