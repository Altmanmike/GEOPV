<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_user');
        }       

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/predec', name: 'app_pre_logout')]
    public function pre_logout(EntityManagerInterface $entityManager, UserRepository $repo): Response
    {        
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u); 
        //dd($user);              
        $user[0]->setNbLogged($user[0]->getNbLogged()-1);
        $user[0]->setIsLogged(false);
        $user[0]->setLastLoginAt(new \DateTimeImmutable());

        $entityManager->persist($user[0]);
        $entityManager->flush();        

        return $this->redirectToRoute('app_logout');

        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
