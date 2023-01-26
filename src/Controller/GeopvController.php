<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PaymentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeopvController extends AbstractController
{
    #[Route('/geopv', name: 'app_geopv')]
    public function index(UserRepository $repo): Response
    {  
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles()) || ($user[0]->isIsAppAcces() == 0) ) {    
            return $this->redirectToRoute('app_user');
        } else {
            return $this->render('geopv/index.html.twig', [
                'controller_name' => 'GeopvController', $user
            ]);
        }
    }
}
