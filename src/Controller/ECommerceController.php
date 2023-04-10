<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Helpers;

class ECommerceController extends AbstractController
{
    public function ecommerce(Helpers $app): Response
    {
        return $this->render('home/ecommerce.html.twig', [
            // 'controller_name' => 'ECommerceController',
            'bodyId' => $app->getBodyId('ECOMMERCE_PAGE'),
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
