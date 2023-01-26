<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Ticket;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    private UserRepository $repo;

    public function __construct(UserRepository $repo){}   

    public function load(ObjectManager $manager): void
    {
        // Génération d'une DataFixtures de fausses données d'un ticket d'un utilisateur via FakerPHP
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 3; $i++)
        {
            $ticket = new Ticket();
            $ticket->setTitle($faker->sentence());
            $ticket->setContent($faker->paragraph());

            // On charge les utilisateurs enregistré via addReference avec getReference
            if($i == 0) {
                $ticket->setUser($this->getReference('user_1'));
                $this->addReference('ticket_1', $ticket);
            } elseif ($i == 1) {
                $ticket->setUser($this->getReference('user_2'));
                $this->addReference('ticket_2', $ticket);
            } elseif ($i == 2) {
                $ticket->setUser($this->getReference('user_3'));
                $this->addReference('ticket_3', $ticket);
            }             

            $manager->persist($ticket);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
