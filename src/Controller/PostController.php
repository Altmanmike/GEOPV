<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\NewPostFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route("/utilisateur/post/nouveau", name:"app_user_createPost")]    
    public function createPost(Request $request, EntityManagerInterface $entityManager, UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur est l'admin
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        // Création d'un post avec informations puis ajout dans la base        
        $post = new Post();
        $form = $this->createForm(NewPostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($user[0]);
            $post->setTitle(htmlspecialchars(trim($form->get('title')->getData())));
            $post->setContent(htmlspecialchars(trim($form->get('content')->getData())));

            $entityManager->persist($post);
            $entityManager->flush();

            $user[0]->setNbPosts(htmlspecialchars(trim($user[0]->getNbPosts()+1)));

            return $this->redirectToRoute('app_user_showPosts'); 
        }

        return $this->render('user/post/create.html.twig', [
            'controller_name' => 'UserController',
            'newPostForm' => $form->createView()
        ]);   
    }

}
