<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Ticket;
use App\Entity\Payment;
use App\Form\NewAnswerFormType;
use App\Form\NewTicketFormType;
use App\Form\ProfileEditFormType;
use App\Repository\UserRepository;
use App\Repository\AnswerRepository;
use App\Repository\TicketRepository;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\NewPaymentFormType;

class UserController extends AbstractController
{    
    #[Route('/utilisateur/bienvenue', name: 'app_user')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, UserRepository $repo): Response
    {            
        // Récupération d'un utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est un admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        if($user[0]->getNbLogged() >= 4)
        {            
            return $this->redirectToRoute('app_logout');
        }

        $user[0]->setIsLogged(true);
        $user[0]->setNbLogged($user[0]->getNbLogged()+1);

        $entityManager->persist($user[0]);
        $entityManager->flush();


        // Si l'accès à l'application est toujours payé        
        if($user[0]->isIsAppAcces())
        {
            return $this->redirectToRoute('app_geopv');
        }
        
        $id = $user[0]->getId();

        // Création d'un formulaire d'édition d'informations utilisateurs puis update dans la base      
        $form = $this->createForm(ProfileEditFormType::class, $user[0]);
        $form->handleRequest($request);        

        if ($form->isSubmitted() && $form->isValid()) { 
            
            $user[0]->setEmail($form->get('email')->getData());
            $user[0]->setRoles($user[0]->getRoles());
            $user[0]->setPassword(
                $userPasswordHasher->hashPassword(
                    $user[0],
                    $form->get('plainPassword')->getData()
                )
            );
            $user[0]->setLastname($form->get('lastname')->getData());
            $user[0]->setFirstname($form->get('firstname')->getData());
            $user[0]->setZipcode($form->get('zipcode')->getData());
            $user[0]->setCity($form->get('city')->getData());

            $entityManager->persist($user[0]);
            $entityManager->flush();

            return $this->redirectToRoute('app_user'); 
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController', $user, $id,
            'profileEditForm' => $form->createView()
        ]);
    }

    #[Route('/utilisateur/tableau', name: 'app_user_dash')]
    public function dash(UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('user/dash.html.twig', [
            'controller_name' => 'UserController'
        ]);
    }

    // Liste des tickets de l'utilisateur -----------------------------------------------------

    #[Route("/utilisateur/tickets", name:"app_user_showTickets")]    
    public function showTickets(UserRepository $repo, TicketRepository $repo1): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération de tous les tickets crées par l'utilisateur et les réponses 
        $tickets = $user[0]->getTickets();
        //dd($tickets);
        
        return $this->render('user/ticket/showAll.html.twig', [
            'controller_name' => 'UserController', 
            'tickets' => $tickets
        ]);
    }

    #[Route("/utilisateur/ticket/{id}", name:"app_user_showTicket")]    
    public function showTicket(Request $request, EntityManagerInterface $entityManager, UserRepository $repo, TicketRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération d'un ticket écrit par l'utilisateur avec informations
        $ticket = $repo1->findById($id);
        //dd($ticket);
        //dd($ticket);   
        $answers = $ticket[0]->getAnswers();
        //dd($answers);    
        /*if($ticket[0]->getAnswers() != null)
        {
            $answers = $ticket[0]->getAnswers();
            //dd($answers);  
        }*/      

       // Création d'une réponse au ticket avec informations puis ajout dans la base        
       $answer = new Answer();
       $form = $this->createForm(NewAnswerFormType::class, $answer);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) { 

           $answer->setContent($form->get('content')->getData());

           $entityManager->persist($answer);
           $entityManager->flush();
           
           $user[0]->setNbAnswers($user[0]->getNbAnswers()+1);

           return $this->redirectToRoute('app_user_showTicket', [ $id ]); 
       }

        return $this->render('user/ticket/show.html.twig', [
            'controller_name' => 'UserController',
            'ticket' => $ticket[0],
            'answers' => $answers,
            $id,
            'newAnswerForm' => $form->createView()
        ]);
    }

    /*#[Route("/utilisateur/ticket/nouveau", name:"app_user_createTicket")]    
    public function createTicket(Request $request, EntityManagerInterface $entityManager, UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Création d'un ticket avec informations puis ajout dans la base        
        $ticket = new Ticket();
        $form = $this->createForm(NewTicketFormType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticket->setTitle($form->get('title')->getData());
            $ticket->setContent($form->get('content')->getData());

            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_showTickets'); 
        }

        return $this->render('user/ticket/create.html.twig', [
            'controller_name' => 'UserController',
            'newTicketForm' => $form->createView()
        ]);   
    }*/

    // Procédure de paiements -----------------------------------------------------------------

    #[Route("/utilisateur/paiement/nouveau", name:"app_user_createPayment")]     // ON UTILISERA CETTE ROUTE APRES PAIEMENT STRIPE SUR STRIPE.HTML.TWIG
    public function createPayment(Request $request, EntityManagerInterface $entityManager, UserRepository $repo, $is_payment_done): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'administrateur
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Création du paiement ici               
        $payment = new Payment();
        $form = $this->createForm(NewPaymentFormType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $payment->setUser($user[0]);
            $payment->setProduct($form->get('product_id')->getData());
            $payment->getPriceUnit($payment->getProduct());
            $payment->setQuantity($form->get('quantity')->getData());
            $payment->setTotalPrice($payment->getQuantity() * $payment->getPriceUnit());            
            $payment->setStatus(1); 

            // Si le paiement est validé par le module de paiement 
            if($is_payment_done) {
                $payment->setStatus(3);
                $payment->setCompletedAt(new \DateTimeImmutable()); 
                // On autorise l'accès à l'application pour l'utilisateur
                $user->setIsAppAccess(1);
            } else {
                $payment->setStatus(2);
            }

            $entityManager->persist($payment);
            $entityManager->flush();

            $user[0]->setNbPayments($user[0]->getNbPayments()+1);

            return $this->redirectToRoute('app_user_payments'); 
        }

        return $this->render('user/payment/create.html.twig', [
            'controller_name' => 'UserController',
            'newPaymentForm' => $form->createView()
        ]);
    }

    #[Route("/utilisateur/paiements", name:"app_user_showPayments")]    
    public function showPayments(UserRepository $repo, PaymentRepository $repo4): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'administrateur
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération de tous les paiements fait par l'utilisateur avec informations
        $payments = $user[0]->getPayments();

        return $this->render('user/payment/showAll.html.twig', [
            'controller_name' => 'UserController',
            'payments' => $payments
        ]);
    }

    #[Route("/utilisateur/paiement/{id}", name:"app_user_showPayment")]    
    public function showPayment(UserRepository $repo, PaymentRepository $repo4, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'administrateur
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération d'un paiement avec informations 
        $payment = $repo4->findById($id);
        //dd($payment[0]);

        return $this->render('user/payment/show.html.twig', [
            'controller_name' => 'UserController', 
            'payment' => $payment[0],
            $id
        ]);
    }
}