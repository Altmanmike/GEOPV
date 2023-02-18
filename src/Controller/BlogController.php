<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(PostRepository $repoP): Response
    {
        $posts = $repoP->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'posts' => $posts
        ]);
    }
}
