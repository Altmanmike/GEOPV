<?php

namespace App\DataFixtures;

//use Faker\Factory;
use App\Entity\Payment;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Génération d'une DataFixtures de fausses données de paiement d'un utilisateur via FakerPHP
        //$faker = Factory::create('fr_FR');

        for($i=0; $i < 8; $i++)
        {
            // Utilisateur et produit randoms;
            $payment = new Payment();
            // Status est l'état de la formule/produit c'est à dire soit: ouvert / en_attente / payé            
            $payment->setStatus(rand(1, 3));           

            if( $payment->getStatus() == 3 )
            {
                // on attend un seconde pour finaliser une commande par rapport 
                // aux dates de creation du paiement et validation de son paiement.
                sleep(1);
                $date = new DateTimeImmutable("now");
                // $current = $date->format('Y-m-d H:m:s');
                $payment->setCompletedAt($date);
            } else {
                $payment->setCompletedAt(null);             
            }

            // On charge les tickets et utilisateurs enregistré via addReference avec getReference
            // et on calcule le prix total en fonction des nombres de jours, semaines ou mois choisis...
            if($i == 0) {
                $payment->setUser($this->getReference('user_1'));
                $payment->setProduct($this->getReference('product_1'));
                $payment->setQuantity(1);
                $payment->setPriceUnit(19.00);
                $payment->setTotalPrice($payment->getPriceUnit() * $payment->getQuantity());

            } elseif($i == 4) {
                $payment->setUser($this->getReference('user_1'));
                $payment->setProduct($this->getReference('product_1'));
                $payment->setQuantity(6);
                $payment->setPriceUnit(19.00);
                $payment->setTotalPrice($payment->getPriceUnit() * $payment->getQuantity());

            } elseif ($i == 1 || $i == 2) {
                $payment->setUser($this->getReference('user_2'));
                $payment->setProduct($this->getReference('product_2'));
                $payment->setQuantity(1);
                $payment->setPriceUnit(95.00);
                $payment->setTotalPrice($payment->getPriceUnit() * $payment->getQuantity());
            } elseif ($i == 3) {
                $payment->setUser($this->getReference('user_2'));
                $payment->setProduct($this->getReference('product_2'));
                $payment->setQuantity(2);
                $payment->setPriceUnit(95.00);
                $payment->setTotalPrice($payment->getPriceUnit() * $payment->getQuantity());
            } elseif ($i == 5 || $i == 7) {
                $payment->setUser($this->getReference('user_3'));
                $payment->setProduct($this->getReference('product_3'));
                $payment->setQuantity(1);
                $payment->setPriceUnit(179.00);
                $payment->setTotalPrice($payment->getPriceUnit() * $payment->getQuantity());
            } elseif ($i == 6) {
                $payment->setUser($this->getReference('user_3'));
                $payment->setProduct($this->getReference('product_3'));
                $payment->setQuantity(3);
                $payment->setPriceUnit(179.00);
                $payment->setTotalPrice($payment->getPriceUnit() * $payment->getQuantity());
            } 

            $manager->persist($payment); 
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class, 
            ProductFixtures::class
        ]; 
    }
}
