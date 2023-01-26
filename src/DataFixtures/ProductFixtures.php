<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void    
    {
        // Ajouter nos 3 produits à la main ici (champs: type, type_price, nb_months, total_paid)
        // PRODUIT 1: accès limité (un certain nombre de requêtes, 20) => 6 € = 10 jetons 
        $product = new Product();
        $product->setType('1');
        $product->setTypePrice(9.00);
        $product->setDescription('Testez notre application durant une journée entière!');        
        $this->addReference('product_1', $product);

        $manager->persist($product);

        // PRODUIT 2: accès limité (un certain nombre de requêtes, 60) => 30 € = 30 jetons
        $product = new Product();
        $product->setType('2');
        $product->setTypePrice(19.00);
        $product->setDescription('Ayez accès à notre application toute la semaine!');          
        $this->addReference('product_2', $product);

        $manager->persist($product);

        // PRODUIT 3: accès full (requêtes illimité) => 19 € pour 1 mois complet
        $product = new Product();
        $product->setType('3');
        $product->setTypePrice(49.00);
        $product->setDescription('Full access à notre application pendant un mois complet!');   
        $this->addReference('product_3', $product);

        $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
