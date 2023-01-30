<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(){}
    public function load(ObjectManager $manager): void
    {
        // Génération d'une DataFixtures de fausses données d'un article (post) d'un utilisateur via FakerPHP

		// Ajouter nos 4 articles à la main ici (champs: title, content, picture, date...)
        // ARTICLE 1
        $post = new Post();
        $post->setTitle('Entrer des vrai titre pour le site');
        $post->setContent('et des vrai contenu pris sur un site officiel');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_1'));
        $this->addReference('post_1', $post);

        $manager->persist($post);

        // ARTICLE 2
		$post = new Post();
        $post->setTitle('Entrer des vrai titre pour le site');
        $post->setContent('et des vrai contenu pris sur un site officiel');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_2'));
        $this->addReference('post_2', $post);

        $manager->persist($post);
		
		// ARTICLE 3
		$post = new Post();
        $post->setTitle('Entrer des vrai titre pour le site');
        $post->setContent('et des vrai contenu pris sur un site officiel');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_3'));
        $this->addReference('post_3', $post);

        $manager->persist($post);
		
		// ARTICLE 4
		$post = new Post();
        $post->setTitle('Entrer des vrai titre pour le site');
        $post->setContent('et des vrai contenu pris sur un site officiel');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_4'));
        $this->addReference('post_4', $post);

        $manager->persist($post);
		
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
