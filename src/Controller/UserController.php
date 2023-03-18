<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\NewCommentFormType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\ProductRepository;
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
    #[Route('/user/welcome', name: 'app_user')]
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
        /*
        if($user[0]->getNbLogged() >= 4)
        {            
            return $this->redirectToRoute('app_logout');
        }*/

        $user[0]->setIsLogged(true);
        //$user[0]->setNbLogged($user[0]->getNbLogged()+1);

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

    #[Route('/user/dash', name: 'app_user_dash')]
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

    // USER TICKETS -----------------------------------------------------

    #[Route("/user/tickets", name:"app_user_showTickets")]
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

    #[Route("/user/ticket/{id}", name:"app_user_showTicket")]
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
           $answer->setUser($user[0]);
           $answer->setTicket($ticket[0]);

           $entityManager->persist($answer);
           $entityManager->flush();

           $user[0]->setNbAnswers($user[0]->getNbAnswers()+1);

           return $this->redirectToRoute('app_user_showTicket', [ $id ] );
       }

        return $this->render('user/ticket/show.html.twig', [
            'controller_name' => 'UserController',
            'ticket' => $ticket[0],
            'answers' => $answers,
            $id,
            'newAnswerForm' => $form->createView()
        ]);
    }

    // USER POSTS -----------------------------------------------------

    #[Route("/user/posts", name:"app_user_showPosts")]
    public function showPosts(Request $request, EntityManagerInterface $entityManager, UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération de tous les articles crées par l'utilisateur et les réponses
        $posts = $user[0]->getPosts();

        return $this->render('user/comment/showAll.html.twig', [
            'controller_name' => 'UserController',
            'posts' => $posts
        ]);
    }

    #[Route("/user/post/{id}", name:"app_user_showPost")]
    public function showPost(Request $request, EntityManagerInterface $entityManager, UserRepository $repo, PostRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération d'un article écrit par l'administrateur avec informations
        $post = $repo1->findById($id);
        //dd($post);
        $comments = $post[0]->getComments();
        //dd($comments);
        /*if($ticket[0]->getComments() != null)
        {
            $comments = $post[0]->getComments();
            //dd($comments);
        }*/

        // Création d'un commentaire à l'article avec informations puis ajout dans la base
        $comment = new Comment();
        $form = $this->createForm(NewCommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setContent($form->get('content')->getData());

            $entityManager->persist($comment);
            $entityManager->flush();

            $user[0]->setNbComments($user[0]->getNbComments()+1);

            return $this->redirectToRoute('app_user_showPost', [ $id ]);
        }

        return $this->render('user/post/show.html.twig', [
            'controller_name' => 'UserController',
            'post' => $post[0],
            'comments' => $comments,
            $id,
            'newCommentForm' => $form->createView()
        ]);
    }


    // USER COMMENTS -----------------------------------------------------

    #[Route("/user/comments", name:"app_user_showComments")]
    public function showComments(Request $request, EntityManagerInterface $entityManager, UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération de tous les commentaires écrit par l'utilisateur avec informations
        $comments = $user[0]->getComments();

        return $this->render('user/comment/showAll.html.twig', [
            'controller_name' => 'UserController',
            'comments' => $comments
        ]);
    }

    // USER PRODUCTS -----------------------------------------------------

    #[Route("/user/product/{id}", name:"app_user_showProduct")]
    public function showProduct(Request $request, EntityManagerInterface $entityManager, UserRepository $repo, ProductRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération d'un produit entré par l'administrateur avec informations
        $product = $repo1->findById($id);
        //dd($product);

        return $this->render('user/post/show.html.twig', [
            'controller_name' => 'UserController',
            'product' => $product[0],
            $id
        ]);
    }

    // USER PAYMENTS -----------------------------------------------------------------

    #[Route("/user/payment/new", name:"app_user_createPayment")]     // ON UTILISERA CETTE ROUTE APRES PAIEMENT STRIPE SUR STRIPE.HTML.TWIG
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

    #[Route("/user/payments", name:"app_user_showPayments")]
    public function showPayments(UserRepository $repo, PaymentRepository $repo4): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'administrateur
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Récupération de tous les paiements fait par l'utilisateur avec informations
        $payments = $user[0]->getPayments();
        //dd($payments);
        return $this->render('user/payment/showAll.html.twig', [
            'controller_name' => 'UserController',
            'payments' => $payments
        ]);
    }

    #[Route("/user/payment/{id}", name:"app_user_showPayment")]
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
        $payment = $repo4->findBy($id);
        //dd($payment[0]);

        return $this->render('user/payment/show.html.twig', [
            'controller_name' => 'UserController', 
            'payment' => $payment[0],
            $id
        ]);
    }
}