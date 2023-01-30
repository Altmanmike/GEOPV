<?php

namespace App\DataFixtures;

use App\Entity\CategoryProduct;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void    
    {
        // Ajouter nos 5 catégories de produits à la main ici (champs: title, content, picture, date...)
        //  CATEGORIE PRODUIT 2
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Formules abonnements');
        $categoryProduct->setContent('Abonnement d\'accès à l\'application');
        $categoryProduct->setPicture('https://via.placeholder.com/200');
        $categoryProduct->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('categoryProduct_1', $categoryProduct);

        $manager->persist($categoryProduct);

        // CATEGORIE PRODUIT 2
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Vêtements');
        $categoryProduct->setContent('Habits avec le logo de l\'application');
        $categoryProduct->setPicture('https://via.placeholder.com/200');
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('categoryProduct_2', $categoryProduct);

        $manager->persist($categoryProduct);

        // CATEGORIE PRODUIT 3
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Casquettes');
        $categoryProduct->setContent('Casquette avec le logo de l\'application');
        $categoryProduct->setPicture('https://via.placeholder.com/200');
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryProduct_3', $categoryProduct);

        $manager->persist($categoryProduct);

        // CATEGORIE PRODUIT 3
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Autres');
        $categoryProduct->setContent('Divers produits de l\'application');
        $categoryProduct->setPicture('https://via.placeholder.com/200');
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('categoryProduct_4', $categoryProduct);

        $manager->persist($categoryProduct);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryPostFixtures::class
        ]; 
    }
}
