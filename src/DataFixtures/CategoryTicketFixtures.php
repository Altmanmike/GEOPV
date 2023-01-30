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
        // Ajouter nos 2 catégories de tickets à la main ici (champs: title, content, date...)
        // Categorie ticket 1
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('Technique');
        $categoryTicket->setContent('Support technique du site');
		$categoryTicket->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('categoryTicket_1', $categoryTicket);

        $manager->persist($categoryTicket);

        // Categorie ticket 2
        $categoryTicket = new CategoryTicket();
        $categoryTicket->setTitle('Commercial');
        $categoryTicket->setContent('Support commercial du site');
		$categoryTicket->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('categoryTicket_2', $categoryTicket);

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
