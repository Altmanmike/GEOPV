<?php

namespace App\DataFixtures;

use App\Entity\CategoryPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryPostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void    
    {
        // Ajouter nos 6 catégories d'articles à la main ici (champs: title, content, picture, date...)
        // CATEGORIE ARTICLE 1
        $categoryPost = new CategoryPost();
        $categoryPost->setTitle('Vaccin');
        $categoryPost->setContent('Vaccination covid-19');
        $categoryPost->setPicture('https://via.placeholder.com/200x100');
		$categoryPost->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryPost_1', $categoryPost);

        $manager->persist($categoryPost);

        // CATEGORIE ARTICLE 2
        $categoryPost = new CategoryPost();
        $categoryPost->setTitle('Achats');
        $categoryPost->setContent('Achats liés à la covid-19');
        $categoryPost->setPicture('https://via.placeholder.com/200x100');
		$categoryPost->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryPost_2', $categoryPost);

        $manager->persist($categoryPost);

        // CATEGORIE ARTICLE 3
        $categoryPost = new CategoryPost();
        $categoryPost->setTitle('International');
        $categoryPost->setContent('La pandémie dans le monde entier');
        $categoryPost->setPicture('https://via.placeholder.com/200x100');
		$categoryPost->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('categoryPost_3', $categoryPost);

        $manager->persist($categoryPost);

        // CATEGORIE ARTICLE 4
        $categoryPost = new CategoryPost();
        $categoryPost->setTitle('Occident');
        $categoryPost->setContent('La covid-19 pas loin de chez vous');
        $categoryPost->setPicture('https://via.placeholder.com/200x100');
		$categoryPost->setCreatedAt(new \DateTimeImmutable());     
        $this->addReference('categoryPost_4', $categoryPost);

        $manager->persist($categoryPost);

        // CATEGORIE ARTICLE 5
        $categoryPost = new CategoryPost();
        $categoryPost->setTitle('Matériel');
        $categoryPost->setContent('Nouveaux et anciens matériel médicaux');
        $categoryPost->setPicture('https://via.placeholder.com/200x100');
		$categoryPost->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryPost_5', $categoryPost);

        $manager->persist($categoryPost);

        // CATEGORIE ARTICLE 6
        $categoryPost = new CategoryPost();
        $categoryPost->setTitle('Vote et lois');
        $categoryPost->setContent('Le juridique et la maladie');
        $categoryPost->setPicture('https://via.placeholder.com/200x100');
		$categoryPost->setCreatedAt(new \DateTimeImmutable());		
        $this->addReference('categoryPost_6', $categoryPost);

        $manager->persist($categoryPost);
		
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
