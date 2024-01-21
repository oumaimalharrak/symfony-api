<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $listauthor=[];
        for ($i=0 ;$i<5;$i++){
            $author = new Author();
            $author->setFirstName('prenom'.$i);
            $author->setLastName("nom".$i);
            // On la persiste
            $manager->persist($author);
            $listauthor[]=$author;

        }
       for ($i=0; $i <20 ; $i++) { 
            $book = new Book();
            $book->setTitle('Le livre ' . $i);
            $book->setCoverText("Ceci est la description du livre n°" .$i);
            $book->setAuthor($listauthor[array_rand($listauthor)]);
            $manager->persist($book);
        }
        $manager->flush(); // Exécution de toutes les requêtes en bdd
    }
}
