<?php

namespace App\Controller;

use App\Service\AppHelpers;
use App\Service\Helpers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    private $app;
    private $userinfo;

    public function __construct(AppHelpers $app){
        $this->app = $app;
        $this->userinfo = $app->getUser();
    }
    // #[Route('/home', name: 'app_home')]
    public function index(Helpers $app): Response
    {
        // dump($this->app->getUser()); exit();
        return $this->render('home/index.html.twig', [
           'bodyId' => $app->getBodyId('HOME_PAGE'),
           'userinfo' => $this->userinfo,
           'img_carousel' => [
            '1' => 'assets/img_carousel/2338290.jpg',
            '2' => 'assets/img_carousel/2593044.jpg',
            '3' => 'assets/img_carousel/vitrine.jfif',
            '4' => 'assets/img_carousel/img4.jfif',
            '5' => 'assets/img_carousel/Image e-commerce mobile.jfif',
            '6' => 'assets/img_carousel/img6.jfif',
            ],
        ]);
    }
}
