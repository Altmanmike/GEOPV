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
        $post->setTitle('Commodo culpa Lorem nostrud occaecat ex proident exercitation.');
        $post->setContent('Nisi ea fugiat ea voluptate sit cupidatat commodo anim enim. Nulla magna qui ad elit excepteur dolor nisi ad culpa. Aliquip nostrud commodo ad non labore. Elit tempor pariatur irure id ipsum consectetur cupidatat et pariatur Lorem officia.');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_1'));
        $post->setCategoryPost($this->getReference('categoryPost_3'));
        $this->addReference('post_1', $post);

        $manager->persist($post);

        // ARTICLE 2
		$post = new Post();
        $post->setTitle('Minim nostrud non mollit esse pariatur aute sit.');
        $post->setContent('Mollit ut exercitation do enim qui ex officia. Tempor sit non excepteur magna. Nisi eiusmod occaecat incididunt incididunt eiusmod nisi est cillum. Est aliquip deserunt est dolore eiusmod nulla tempor Lorem esse aliqua irure excepteur quis dolore. Esse ad incididunt aliquip cillum eiusmod proident sit incididunt. Incididunt proident sunt culpa enim cillum nostrud voluptate commodo officia.

Velit laboris do officia ea quis. Ullamco veniam ea id occaecat consectetur in in reprehenderit amet nisi ut ea. Veniam do quis deserunt irure cupidatat ad mollit reprehenderit occaecat Lorem laborum dolor. Nisi ad ullamco eiusmod ipsum et.');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_2'));
        $post->setCategoryPost($this->getReference('categoryPost_1'));
        $this->addReference('post_2', $post);

        $manager->persist($post);
		
		// ARTICLE 3
		$post = new Post();
        $post->setTitle('Cillum veniam nulla Lorem velit ea.');
        $post->setContent('Pariatur aute reprehenderit quis aute est est commodo est aute anim. Labore eiusmod adipisicing dolore nostrud anim nulla velit est est nulla velit consectetur deserunt. Fugiat cillum pariatur consectetur anim adipisicing. Ullamco occaecat ut dolore laboris ea. Ut magna laborum sint deserunt cillum exercitation do reprehenderit reprehenderit id et irure. Cupidatat ut do magna est incididunt quis. Cupidatat nisi culpa sint dolore in.');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_3'));
        $post->setCategoryPost($this->getReference('categoryPost_2'));
        $this->addReference('post_3', $post);

        $manager->persist($post);
		
		// ARTICLE 4
		$post = new Post();
        $post->setTitle('Veniam magna amet nulla eiusmod sit exercitation tempor esse commodo.');
        $post->setContent('Minim id occaecat veniam occaecat excepteur laboris deserunt. Ullamco in deserunt ipsum reprehenderit pariatur ad. Pariatur sunt ullamco minim fugiat excepteur. Sit aliqua culpa voluptate sint ex do in do consectetur consectetur. Sit ullamco tempor reprehenderit duis. Non non exercitation ex elit eiusmod sit proident eu enim quis laboris qui velit. Adipisicing tempor esse aliqua sint aute tempor eu aliqua.

Nisi minim commodo incididunt enim. Excepteur commodo duis excepteur consectetur ex enim commodo culpa amet ea aliquip magna pariatur. Occaecat esse cillum veniam est esse labore culpa proident.

Id incididunt occaecat enim aute consequat sunt nostrud exercitation ut sint. Eiusmod elit voluptate officia commodo Lorem dolore enim. Anim adipisicing esse velit eu sit est reprehenderit do. Esse excepteur Lorem laboris sint nulla est consectetur duis elit nisi ullamco officia. Adipisicing consequat ad enim voluptate ex labore pariatur laboris.');
        $post->setPicture('https://via.placeholder.com/700x500');
		$post->setCreatedAt(new \DateTimeImmutable());
        $post->setUser($this->getReference('user_4'));
        $post->setCategoryPost($this->getReference('categoryPost_5'));
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