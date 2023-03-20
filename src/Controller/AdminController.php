<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Comment;
use App\Form\NewAnswerFormType;
use App\Form\NewCommentFormType;
use App\Repository\UserRepository;
use App\Repository\AnswerRepository;
use App\Repository\TicketRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\PaymentRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Types\DateImmutableType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $repo, EntityManagerInterface $entityManager, TicketRepository $repoT, AnswerRepository $repoA, PostRepository $repoS, CommentRepository $repoC, PaymentRepository $repoP): Response
    {
        //dd($repo);
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());
        //$user[0]->getLastLoginAt();

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }
        //dd($user[0]->getRoles());

        $user[0]->setIsLogged(true);
        //$user[0]->setNbLogged(1);

        $entityManager->persist($user[0]);
        $entityManager->flush();

        $users = $repo->findAll();
        
        // Initialisation des variables de comptage des items pour notifications
		$nb_new_posts = 0;
        $nb_new_comments = 0;
        $nb_new_tickets = 0;
        $nb_new_answers = 0;
        $nb_new_payments = 0;
        
		$posts = $repoS->findAll();
        for($i = 0; $i < sizeof($posts); $i++)
        {
            if($posts[$i]->getCreatedAt() > $user[0]->getLastLoginAt())   // vérif comparer dateimmutable 
            {
                $nb_new_posts++;
            } 
        }
        
        $comments = $repoC->findAll();
        for($i = 0; $i < sizeof($comments); $i++)
        {
            if($comments[$i]->getCreatedAt() > $user[0]->getLastLoginAt())   // vérif comparer dateimmutable 
            {
                $nb_new_comments++;
            }
        } 
		
        $tickets = $repoT->findAll();
        for($i = 0; $i < sizeof($tickets); $i++)
        {
            if($tickets[$i]->getCreatedAt() > $user[0]->getLastLoginAt())   // vérif comparer dateimmutable 
            {
                $nb_new_tickets++;
            } 
        }
        
        $answers = $repoA->findAll();
        for($i = 0; $i < sizeof($answers); $i++)
        {
            if($answers[$i]->getCreatedAt() > $user[0]->getLastLoginAt())   // vérif comparer dateimmutable 
            {
                $nb_new_answers++;
            }
        }        

        /*$payments = $repoP->findAll();
        for($i = 0; $i < sizeof($payments); $i++)
        {
            if($payments[$i]->getCreatedAt() > $user[0]->getLastLoginAt())   // vérif comparer dateimmutable 
            {
                $nb_new_payments++;
            } 
        }*/

        return $this->render('easy-admin/dash_index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'posts' => $posts,
			'comments' => $comments,
            'tickets' => $tickets,
			'answers' => $answers,
            /*'payments' => $payments,*/
            'nb_new_posts' => $nb_new_posts, 
            'nb_new_comments' => $nb_new_comments, 
			'nb_new_tickets' => $nb_new_tickets, 
            'nb_new_answers' => $nb_new_answers, 
            /*'nb_new_payments' => $nb_new_payments,*/
        ]);
    }
        
    // ADMIN CURRENTDATA RESUME ---------------------------------------------------

    #[Route('/admin/users-data', name: 'app_admin_showUsersData')]
    public function indexData(UserRepository $repo, EntityManagerInterface $entityManager, TicketRepository $repoT, AnswerRepository $repoA, PostRepository $repoS, CommentRepository $repoC, PaymentRepository $repoP): Response
    {
        //dd($repo);
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());
        //$user[0]->getLastLoginAt();

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }
        //dd($user[0]->getRoles());
        $results = $repo->findAll();
        /*$users = $results;
        $posts = $repoS->findAll();
        $comments = $repoC->findAll();
        $tickets = $repoT->findAll();
        $answers = $repoA->findAll();
        $payments = $repoP->findAll();*/

        return $this->render('Admin/resume.html.twig', [
            'controller_name' => 'AdminController',
            'results' => $results,
            /*'users' => $users,
            'posts' => $posts,
            'comments' => $comments,
            'tickets' => $tickets,
            'answers' => $answers,
            'payments' => $payments*/
        ]);
    }

    // ADMIN USERS ---------------------------------------------------------
    
    #[Route("/admin/users", name:"app_admin_showUsers")]
    public function showUsers(UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }
        
        // Récupération de tous les utilisateurs avec informations 
        $users = $repo->findAll();        
        //dd($users);

        return $this->render('admin/user/showAll.html.twig', [
            'controller_name' => 'AdminController', 
            'users' => $users
        ]);
    }

    #[Route("/admin/user/{id}", name:"app_admin_showUser")]
    public function showUser(UserRepository $repo, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un utilisateur avec informations 
        $user = $repo->findById($id);
        //dd($user);

        return $this->render('admin/user/show.html.twig', [
            'controller_name' => 'AdminController', 
            'user' => $user[0], 
            $id
        ]);
    }

    #[Route("/admin/user/{id}/del", name:"app_admin_deleteUser")]
    public function deleteUser(UserRepository $repo, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un utilisateur avec informations puis suppression de la base
        $user = $repo->findById($id);   
        $repo->remove($user[0], true);            

        return $this->redirectToRoute('app_admin_showUsers');
    }


    // ADMIN TICKETS -------------------------------------------------------------

    #[Route("/admin/tickets", name:"app_admin_showTickets")]    
    public function showTickets(UserRepository $repo, TicketRepository $repo1): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération de tous les tickets et réponses avec informations
        $tickets = $repo1->findAll();
        //dd($tickets);
        
        return $this->render('admin/ticket/showAll.html.twig', [
            'controller_name' => 'AdminController', 
            'tickets' => $tickets
        ]);
    }

    #[Route("/admin/ticket/{id}", name:"app_admin_showTicket")]    
    public function showTicket(Request $request, EntityManagerInterface $entityManager, UserRepository $repo, TicketRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());
        
        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un ticket avec informations
        $ticket = $repo1->findById($id);
        $answers = $ticket[0]->getAnswers();
        //dd($answers);        
        
        // Création d'une réponse au ticket avec informations puis ajout dans la base        
        $answer = new Answer();       
        $form = $this->createForm(NewAnswerFormType::class, $answer);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $answer->setContent(htmlspecialchars(trim($form->get('content')->getData())));
            $answer->setUser($user[0]);
            $answer->setTicket($ticket[0]);

            $entityManager->persist($answer);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_showTicket', [ 'id' => $id ]); 
        }

        return $this->render('admin/ticket/show.html.twig', [
            'controller_name' => 'AdminController',
            'ticket' => $ticket[0],
            'answers' => $answers,
            $id,
            'newAnswerForm' => $form->createView()
        ]);
    }

    #[Route("/admin/ticket/{id}/del", name:"app_admin_deleteTicket")]
    public function deleteTicket(UserRepository $repo, TicketRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un ticket avec informations puis suppression de la base
        $ticket = $repo1->findById($id);
        $repo->remove($ticket);

        return $this->redirectToRoute('app_admin_showTickets');
    }

    #[Route("/admin/ticket/{id}/close", name:"app_admin_closeTicket")]
    public function closeTicket(EntityManagerInterface $entityManager, UserRepository $repo, TicketRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un ticket avec informations puis mise à jour de la date dans la bdd
        $ticket = $repo1->findById($id);
        //dd($ticket);
        $ticket[0]->setCompletedAt(new \DateTimeImmutable()); 

        $entityManager->persist($ticket[0]);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_showTickets');
    }


    // ADMIN POSTS -------------------------------------------------------------

    #[Route("/admin/posts", name:"app_admin_showPosts")]    
    public function showPosts(UserRepository $repo, PostRepository $repo1): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération de tous les posts et réponses avec informations
        $posts = $repo1->findAll();
        //dd($posts);
        
        return $this->render('admin/post/showAll.html.twig', [
            'controller_name' => 'AdminController', 
            'posts' => $posts
        ]);
    }

    #[Route("/admin/post/{id}", name:"app_admin_showPost")]    
    public function showPost(Request $request, EntityManagerInterface $entityManager, UserRepository $repo, PostRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());
        
        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un post avec informations
        $post = $repo1->findById($id);
        $comments = $post[0]->getComments();
        //dd($comments);        
        
        // Création d'une réponse au post avec informations puis ajout dans la base        
        $comment = new Comment();       
        $form = $this->createForm(NewCommentFormType::class, $comment);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $comment->setContent(htmlspecialchars(trim($form->get('content')->getData())));
            $comment->setUser($user[0]);
            $comment->setPost($post[0]);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_showPost', [ 'id' => $id ]); 
        }

        return $this->render('admin/post/show.html.twig', [
            'controller_name' => 'AdminController',
            'post' => $post[0],
            'comments' => $comments,
            $id,
            'newCommentForm' => $form->createView()
        ]);
    }

    #[Route("/admin/post/{id}/del", name:"app_admin_deletePost")]
    public function deletePost(UserRepository $repo, PostRepository $repo1, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un post avec informations puis suppression de la base
        $post = $repo1->findById($id);
        $repo->remove($post);

        return $this->redirectToRoute('app_admin_showPosts');
    }


    // ADMIN PRODUCTS -----------------------------------------------------------------

    #[Route("/admin/products", name:"app_admin_showProducts")]
    public function showProducts(UserRepository $repo, ProductRepository $repo3): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération de tous les produits avec informations 
        $products = $repo3->findAll();
        //dd($products);

        return $this->render('admin/product/showAll.html.twig', [
            'controller_name' => 'AdminController',
            'products' => $products
        ]);
    }

    #[Route("/admin/product/{id}", name:"app_admin_showProduct")]
    public function showProduct(UserRepository $repo, ProductRepository $repo3, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un produit avec informations
        $product = $repo3->findById($id);
        //dd($product[0]);

        return $this->render('admin/product/show.html.twig', [
            'controller_name' => 'AdminController', 
            'product' => $product[0],
            $id
        ]);
    }

    #[Route("/admin/product/{id}/del", name:"app_admin_deleteProduct")]
    public function deleteProduct(UserRepository $repo, ProductRepository $repo3, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un produit avec informations puis suppression de la base
        $product = $repo3->findById($id);
        $repo->remove($product);    // remove marche qu'avec user

        return $this->redirectToRoute('app_admin_showProducts');
    }


    // ADMIN PAYMENTS -----------------------------------------------------------------

    #[Route("/admin/payments", name:"app_admin_showPayments")]
    public function showPayments(UserRepository $repo, PaymentRepository $repo4): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération de tous les paiements avec informations
        $payments = $repo4->findAll();
        //dd($payments);

        return $this->render('admin/payment/showAll.html.twig', [
            'controller_name' => 'AdminController',
            'payments' => $payments
        ]);
    }

    #[Route("/admin/payment/{id}", name:"app_admin_showPayment")]
    public function showPayment(UserRepository $repo, PaymentRepository $repo4, $id): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Récupération d'un paiement avec informations 
        $payment = $repo4->findById($id);
        //dd($payment[0]);

        return $this->render('admin/payment/show.html.twig', [
            'controller_name' => 'AdminController', 
            'payment' => $payment[0],
            $id
        ]);
    }
}
