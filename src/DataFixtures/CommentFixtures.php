<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Génération d'une DataFixtures de fausses données de réponses d'un ticket d'un utilisateur via FakerPHP
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 3; $i++)
        {
            $comment = new Comment();
            $comment->setContent($faker->paragraph());

            // On charge les articles et utilisateurs enregistré via addReference avec getReference
            if($i == 0) {
                $comment->setUser($this->getReference('user_1'));
                $comment->setPost($this->getReference('post_1'));

            } elseif ($i == 1) {
                $comment->setUser($this->getReference('user_2'));
                $comment->setPost($this->getReference('post_2'));
            } elseif ($i == 2) {
                $comment->setUser($this->getReference('user_3'));
                $comment->setPost($this->getReference('post_3'));
            } 

            $manager->persist($comment);
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
