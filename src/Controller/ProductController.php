<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\NewProductFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route("/admin/product/new", name:"app_admin_createProduct")]
    public function createProduct(Request $request, EntityManagerInterface $entityManager, UserRepository $repo): Response
    {
        // Récupération de l'utilisateur avec informations (array)
        $u = $this->getUser()->getUserIdentifier();        
        $user = $repo->findByEmail($u);
        //dd($user[0]->getRoles());

        // Si l'utilisateur n'est pas l'administrateur
        if (!in_array('ROLE_ADMIN', $user[0]->getRoles())) {
            return $this->redirectToRoute('app_user');
        }

        // Création d'un produit avec informations puis ajout dans la base
        $product = new Product();
        $form = $this->createForm(NewProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUser($user[0]);
            $product->setTitle(htmlspecialchars(trim($form->get('title')->getData())));
            $product->setType(htmlspecialchars(trim($form->get('type')->getData())));
            $product->setTypePrice(htmlspecialchars(trim($form->get('type_price')->getData())));
            $product->setDescription(htmlspecialchars(trim($form->get('description')->getData())));
            $product->setPicture(htmlspecialchars(trim($form->get('picture')->getData())));

            $entityManager->persist($product);
            $entityManager->flush();

            $user[0]->setNbProducts(htmlspecialchars(trim($user[0]->getNbProducts()+1)));

            return $this->redirectToRoute('app_admin_showProducts');
        }

        return $this->render('admin/product/create.html.twig', [
            'controller_name' => 'PostController',
            'newProductForm' => $form->createView()
        ]);   
    }

}
