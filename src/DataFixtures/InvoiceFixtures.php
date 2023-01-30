<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void    
    {
        // Ajouter nos 8 factures à la main ici (champs: id, createdAt, completedAt, user_id, payment_id)
        // Invoice 1:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_3'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_1', $invoice);

        $manager->persist($invoice);

        // Invoice 2:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_1'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_2', $invoice);

        $manager->persist($invoice);

        // Invoice 3:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_3'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_3', $invoice);

        $manager->persist($invoice);

        // Invoice 4:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_1'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_4', $invoice);

        $manager->persist($invoice);

        // Invoice 5:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_2'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_5', $invoice);

        $manager->persist($invoice);

        // Invoice 6:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_2'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_6', $invoice);

        $manager->persist($invoice);

        // Invoice 7:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_1'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_7', $invoice);

        $manager->persist($invoice);

        // Invoice 8:
        $invoice = new Invoice();
        $invoice->setUser($this->getReference('user_4'));
        $invoice->setCreatedAt(new \DateTimeImmutable());
        $this->addReference('invoice_8', $invoice);

        $manager->persist($invoice);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ]; 
    }
}
