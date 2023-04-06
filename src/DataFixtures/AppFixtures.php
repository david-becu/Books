<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $listAuthor = [];
        for ($i = 0; $i < 10; $i++) {
            // Création des auteurs
            $author = new Author();
            $author->setFirstName("Prénom " . $i);
            $author->setLastName("Nom " . $i);
            $manager->persist($author);
            
            // Sauvegarde de l'auteur dans un tableau
            $listAuthor[] = $author;
        }
        
        // Création des livres
        for ($i = 0; $i < 20; $i++) {
            // Création d'un livre
            $book = new Book();
            $book->setTitle(sprintf('Livre %d', $i));
            $book->setCoverText(sprintf('Numéro : %d', $i));
            
            // Pour lier le livre à un auteur pris au hasard dans le tableau des auteurs :
            $book->setAuthor($listAuthor[array_rand($listAuthor)]);
            
            $manager->persist($book);
        }

        $manager->flush();
    }
}
