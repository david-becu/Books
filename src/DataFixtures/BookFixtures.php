<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $livre = new Book();
            $livre->setTitle(sprintf('Livre %d', $i));
            $livre->setCoverText(sprintf('Numéro : %d', $i));
            $manager->persist($livre);
        }

        $manager->flush();
    }
}
