<?php

namespace App\DataFixtures;

use App\Entity\CategoryTicket;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryTicketFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void    
    {
        // Ajouter nos 6 catégories de tickets à la main ici (champs: title, content, picture, date...)
        //  CATEGORIE ARTICLE 1
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('Vaccin');
        $categoryTicket->setContent('Vaccination covid-19');
        //$categoryTicket->setPicture('https://ssdfsdfsdfsdfsdf');
		$categoryTicket->setCreatedAt(new \DateTimeImmutable()); 		
        $this->addReference('categoryTicket_1', $categoryTicket);

        $manager->persist($categoryTicket);

        //  CATEGORIE ARTICLE 2
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('Achats');
        $categoryTicket->setContent('Achats liés à la covid-19');
        //$categoryTicket->setPicture('https://ssdfsdfsdfsdfsdf');
		$categoryTicket->setCreatedAt(new \DateTimeImmutable()); 		
        $this->addReference('categoryTicket_2', $categoryTicket);

        $manager->persist($categoryTicket);

        // CATEGORIE ARTICLE 3
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('International');
        $categoryTicket->setContent('La pandémie dans le monde entier');
        //$categoryTicket->setPicture('https://ssdfsdfsdfsdfsdf'); 
		$categoryTicket->setCreatedAt(new \DateTimeImmutable()); 
        $this->addReference('categoryTicket_3', $categoryTicket);

        $manager->persist($categoryTicket);

        //  CATEGORIE ARTICLE 4
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('Occident');
        $categoryTicket->setContent('La covid-19 pas loin de chez vous');
        //$categoryTicket->setPicture('https://ssdfsdfsdfsdfsdf');  
		$categoryTicket->setCreatedAt(new \DateTimeImmutable()); 		
        $this->addReference('categoryTicket_4', $categoryTicket);

        $manager->persist($categoryTicket);

        //  CATEGORIE ARTICLE 5
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('Matériel');
        $categoryTicket->setContent('Nouveaux et anciens matériel médicaux');
        //$categoryTicket->setPicture('https://ssdfsdfsdfsdfsdf');  
		$categoryTicket->setCreatedAt(new \DateTimeImmutable()); 		
        $this->addReference('categoryTicket_5', $categoryTicket);

        $manager->persist($categoryTicket);

        // CATEGORIE ARTICLE 6
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('Vote et lois');
        $categoryTicket->setContent('Le juridique et la maladie');
        //$categoryTicket->setPicture('https://ssdfsdfsdfsdfsdf');  
		$categoryTicket->setCreatedAt(new \DateTimeImmutable()); 		
        $this->addReference('categoryTicket_6', $categoryTicket);

        $manager->persist($categoryTicket);
		
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
