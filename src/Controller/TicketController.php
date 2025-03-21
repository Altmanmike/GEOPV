<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\NewTicketFormType;
use App\Repository\CategoryTicketRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    #[Route("/user/ticket/new", name:"app_user_createTicket")]
    public function createTicket(Request $request, EntityManagerInterface $entityManager, UserRepository $repo, CategoryTicketRepository $repoCT): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // récupération de toutes les catégories de ticket possible
        $categories_ticket = $repoCT->findAll();
        //dd($categories_ticket);

        // Création d'un ticket avec informations puis ajout dans la base        
        $ticket = new Ticket();
        $form = $this->createForm(NewTicketFormType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setUser($user[0]);
            $ticket->setTitle($form->get('title')->getData());
            $ticket->setContent($form->get('content')->getData());
            $ticket->setCategoryTicket($form->get('category_ticket')->getData());
            $entityManager->persist($ticket);
            $entityManager->flush();

            $user[0]->setNbTickets($user[0]->getNbTickets()+1);

            return $this->redirectToRoute('app_user_showTickets'); 
        }

        return $this->render('user/ticket/create.html.twig', [
            'controller_name' => 'UserController',
            'categories_ticket' => $categories_ticket,
            'newTicketForm' => $form->createView()
        ]);   
    }
}
