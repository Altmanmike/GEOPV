<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ticket;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(){}

    public function load(ObjectManager $manager): void
    {
        // Génération d'une DataFixtures de fausses données de réponses d'un ticket d'un utilisateur via FakerPHP
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 3; $i++)
        {
            $ticket = new Ticket();
            $ticket->setTitle($faker->sentence());
            $ticket->setContent($faker->paragraph());
            //$ticket->setCategoryTicket(rand(1, 3)); PROBLEME ON CHARGE 9A AVANT....
            $ticket->setCreatedAt(new \DateTimeImmutable());

            // On charge les utilisateurs enregistrés via addReference avec getReference
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
