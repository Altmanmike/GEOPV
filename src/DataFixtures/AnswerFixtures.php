<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Answer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Génération d'une DataFixtures de fausses données de réponses d'un ticket d'un utilisateur via FakerPHP
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 3; $i++)
        {
            $answer = new Answer();
            $answer->setContent($faker->paragraph());

            // On charge les tickets et utilisateurs enregistré via addReference avec getReference
            if($i == 0) {
                $answer->setUser($this->getReference('user_1'));
                $answer->setTicket($this->getReference('ticket_1'));

            } elseif ($i == 1) {
                $answer->setUser($this->getReference('user_2'));
                $answer->setTicket($this->getReference('ticket_2'));
            } elseif ($i == 2) {
                $answer->setUser($this->getReference('user_3'));
                $answer->setTicket($this->getReference('ticket_3'));
            } 

            $manager->persist($answer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            TicketFixtures::class
        ]; 
    }
}
