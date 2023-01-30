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

        // PRODUIT 4: teeshirt noir
        $product = new Product();
        $product->setType('4');
        $product->setTypePrice(60.00);
        $product->setDescription('Teeshirt de l\'application pour faire du sport');
        $product->setPicture($_SERVER['DOCUMENT_ROOT'].'/assets/img/geopv_product_teeshirt.png');
        $this->addReference('product_4', $product);

        $manager->persist($product);

        // PRODUIT 5: casquette noire
        $product = new Product();
        $product->setType('4');
        $product->setTypePrice(23.00);
        $product->setDescription('Casquette noire avec le logo de l\'application');
        $product->setPicture($_SERVER['DOCUMENT_ROOT'].'/assets/img/geopv_product_black_cap.png');
        $this->addReference('product_5', $product);

        $manager->persist($product);

        // PRODUIT 6: casquette red
        $product = new Product();
        $product->setType('4');
        $product->setTypePrice(25.00);
        $product->setDescription('Casquette rouge avec le logo de l\'application');
        $product->setPicture($_SERVER['DOCUMENT_ROOT'].'/assets/img/geopv_product_red_cap.png');
        $this->addReference('product_6', $product);

        $manager->persist($product);

        // PRODUIT 7: porte-clé
        $product = new Product();
        $product->setType('4');
        $product->setTypePrice(4.00);
        $product->setDescription('Porte-clé avec le logo de l\'application');
        $product->setPicture($_SERVER['DOCUMENT_ROOT'].'/assets/img/geopv_product_key.png');
        $this->addReference('product_7', $product);

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
