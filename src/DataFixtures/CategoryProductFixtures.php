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
        //  CATEGORIE PRODUIT 1
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Vaccin');
        $categoryProduct->setContent('Vaccination covid-19');
        $categoryProduct->setPicture('https://ssdfsdfsdfsdfsdf'); 
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryProduct_1', $categoryProduct);

        $manager->persist($categoryProduct);

        //  CATEGORIE PRODUIT 2
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Achats');
        $categoryProduct->setContent('Achats liés à la covid-19');
        $categoryProduct->setPicture('https://ssdfsdfsdfsdfsdf');  
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryProduct_2', $categoryProduct);

        $manager->persist($categoryProduct);

        // CATEGORIE PRODUIT 3
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('International');
        $categoryProduct->setContent('La pandémie dans le monde entier');
        $categoryProduct->setPicture('https://ssdfsdfsdfsdfsdf'); 
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('categoryProduct_3', $categoryProduct);

        $manager->persist($categoryProduct);

        //  CATEGORIE PRODUIT 4
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Occident');
        $categoryProduct->setContent('La covid-19 pas loin de chez vous');
        $categoryProduct->setPicture('https://ssdfsdfsdfsdfsdf');
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());     
        $this->addReference('categoryProduct_4', $categoryProduct);

        $manager->persist($categoryProduct);

        //  CATEGORIE PRODUIT 5
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle('Matériel');
        $categoryProduct->setContent('Nouveaux et anciens matériel médicaux');
        $categoryProduct->setPicture('https://ssdfsdfsdfsdfsdf'); 
		$categoryProduct->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryProduct_5', $categoryProduct);

        $manager->persist($categoryProduct);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
