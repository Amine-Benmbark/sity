<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\services\Helpers;
use App\Service\AppHelpers;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContactController extends AbstractController
{
    private $params;
    private $doctrine;
    private $security;
    private $db;
    private $session;
    private $user;
    private $app;

    public function __construct(ContainerBagInterface $params, ManagerRegistry $doctrine, Security $security, RequestStack $requestStack, AppHelpers $app){

        $this->params = $params;
        $this->doctrine = $doctrine;
        $this->db = $doctrine->getManager();
        $this->security = $security;
        $this->user = $app->getUser();

        $this->session = $requestStack->getSession();
    }


    public function contact(AppHelpers $app, Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $contact = new Contact();

        if($this->getUser()) {
            $contact->setName($this->getUser()->getName())
                    ->setFirstname($this->getUser()->getFirstname())
                    ->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(ContactFormType::class, $contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $form = $this->createForm(ContactFormType::class, $contact);

            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush();
// Envoi sur la boite mail

            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('support@sitna.fr')
            ->subject($contact->getSujet())
            ->htmlTemplate('contact/contactMail.html.twig')
            ->context([
                    'contact' => $contact
                   ]);
            // $htmlBody = $email->getHtmlBody();


        $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre message à été envoyé avec succès !'
            );

        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
            // 'bodyId' => $app->getBodyId('CONTACT'),
            'userInfo' => $this->user,
        ]);
    }
}