<?php

namespace App\Controller;

use App\Repository\DataUserRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/data/usersInfos', name: 'app_data_users_infos')]
    public function dataUserInfos(): Response
    {
        $usersInfos = $this->dataUserRepo->getUsersInfos();
        //dd($usersInfos);
        return $this->render('data_user/showInfos.html.twig', [
            'controller_name' => 'DataUserController',
            'usersInfos' => $usersInfos
        ]);
    }

    #[Route('/data/user/{id}', name: 'app_data_user_showOne')]
    public function dataUser($id, UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $uz = $this->getUser()->getUserIdentifier();
        $u = $repo->findByEmail($uz);

        $user = $this->dataUserRepo->getOneUser($id);

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
    public function dataUserCreate(UserRepository $repo, Request $request): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repo->findByEmail($u);

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        $email = $request->get('email'); // essayer ça sinon $request->request->get
        $roles = ['ROLES_USER'];
        $pwd = $request->get('pwd');
        $fname = $request->get('fname');
        $lname = $request->get('lname');
        $phone = $request->get('phone');
        $company = $request->get('company');
        $zipcode = $request->get('zipcode');
        $city = $request->get('city');

        $submittedToken = $request->get('token');
        if ($this->isCsrfTokenValid('create-item', $submittedToken)) {
            $this->dataUserRepo->createOneUser($email, $roles, $pwd, $fname, $lname, $phone, $company, $zipcode, $city);
        }
        return $this->redirectToRoute('app_data_users_showAll');
    }
	
	#[Route('/data/user/{id}/edit', name: 'app_data_user_editOne')]
    public function dataUserEdit(UserRepository $repo, $id, Request $request): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();
        $user = $repo->findByEmail($u);

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        $email = $request->get('email');
        $roles = $request->get('roles');
        $fname = $request->get('fname');
        $lname = $request->get('lname');
        $phone = $request->get('phone');
        $company = $request->get('company');
        $zipcode = $request->get('zipcode');
        $city = $request->get('city');

        $submittedToken = $request->get('token');
        if ($this->isCsrfTokenValid('edit-item', $submittedToken)) {
            $this->dataUserRepo->editOneUser($email, $roles, $fname, $lname, $phone, $company, $zipcode, $city);
        }
        return $this->redirectToRoute('app_data_users_showAll');
    }
}
