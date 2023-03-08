<?php

namespace App\Controller;

use App\Repository\DataUserRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataUserController extends AbstractController
{
	private DataUserRepository $dataUserRepo;
	
	public function __construct(DataUserRepository $dataUserRepo) {
		$this->dataUserRepo = $dataUserRepo;
	}
	
    #[Route('/data/users', name: 'app_data_users_showAll')]
    public function index(): Response
    {
        $users = $this->dataUserRepo->getAllUsers();

        return $this->render('data_user/showAll.html.twig', [
            'controller_name' => 'DataUserController',
            'users' => $users
        ]);
    }

    #[Route('/data/user/{id}', name: 'app_data_user_showOne')]
    public function dataUser($id, UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $uz = $this->getUser()->getUserIdentifier();
        $u = $repo->findByEmail($uz);
        //dd($user[0]->getRoles());

        $user = $this->dataUserRepo->getOneUser($id);
        //dd($user);

        return $this->render('data_user/show.html.twig', [
            'controller_name' => 'DataUserController',
            'user' => $user,
            'u' => $u[0]
        ]);
    }

    #[Route('/data/user/{id}/del', name: 'app_data_user_deleteOne')]
    public function dataUserDel($id): Response
    {
        $this->dataUserRepo->delOneUser($id);
        return $this->redirectToRoute('app_data_users_showAll');
    }

    #[Route('/data/users/purge', name: 'app_data_users_deleteAll')]
    public function dataUsersDel(): Response
    {
        $this->dataUserRepo->purgeUserTable();
        return $this->redirectToRoute('app_data_users_showAll');
    }

    #[Route('/data/user/new', name: 'app_data_user_create')]
    public function dataUserCreate(): Response
    {
        $this->dataUserRepo->createOneUser();
        return $this->redirectToRoute('app_data_users_showAll');
    }
	
	#[Route('/data/user/{id}/edit', name: 'app_data_user_editOne')]
    public function dataUserEdit($id): Response
    {
        $email = $_GET['email'];
        $fname = $_GET['fname'];
        $lname = $_GET['lname'];
        $phone = $_GET['phone'];
        $company = $_GET['company'];
        $zipcode = $_GET['zipcode'];
        $city = $_GET['city'];

        $this->dataUserRepo->editOneUser($email, $fname, $lname, $phone, $company, $zipcode, $city);

        return $this->redirectToRoute('app_data_users_showAll');
    }
}
