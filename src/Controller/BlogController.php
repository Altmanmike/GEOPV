<?php

namespace App\Controller;

use App\Repository\CategoryPostRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(UserRepository $repoU, PostRepository $repoP, CategoryPostRepository $repoCP): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repoU->findByEmail($u);

        // Si l'utilisateur n'est pas l'administrateur
        if (in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        $posts = $repoP->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'posts' => $posts
        ]);
    }
}
