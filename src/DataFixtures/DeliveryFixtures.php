<?php

namespace App\DataFixtures;

use App\Entity\Delivery;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DeliveryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void    
    {
        // Ajouter nos 8 bons de livraisons à la main ici (champs: id, createdAt, completedAt, user_id)
        // Delivery 1:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_3'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_1', $delivery);

        $manager->persist($delivery);

        // Delivery 2:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_1'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_2', $delivery);

        $manager->persist($delivery);

        // Delivery 3:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_3'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_3', $delivery);

        $manager->persist($delivery);

        // Delivery 4:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_1'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_4', $delivery);

        $manager->persist($delivery);

        // Delivery 5:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_2'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_5', $delivery);

        $manager->persist($delivery);

        // Delivery 6:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_2'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_6', $delivery);

        $manager->persist($delivery);

        // Delivery 7:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_1'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_7', $delivery);

        $manager->persist($delivery);

        // Delivery 8:
        $delivery = new Delivery();
        $delivery->setUser($this->getReference('user_4'));
        $delivery->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('delivery_8', $delivery);

        $manager->persist($delivery);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
