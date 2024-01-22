<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        //create user
        $user = new User();
        $user->setEmail('email@book.com');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        //create admin
        $user = new User();
        $user->setEmail('admin@book.com');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);


        $listauthor = [];
        for ($i = 0; $i < 5; $i++) {
            $author = new Author();
            $author->setFirstName('prenom' . $i);
            $author->setLastName("nom" . $i);
            // On la persiste
            $manager->persist($author);
            $listauthor[] = $author;
        }
        for ($i = 0; $i < 20; $i++) {
            $book = new Book();
            $book->setTitle('Le livre ' . $i);
            $book->setCoverText("Ceci est la description du livre n°" . $i);
            $book->setAuthor($listauthor[array_rand($listauthor)]);
            $manager->persist($book);
        }
        $manager->flush(); // Exécution de toutes les requêtes en bdd
    }
}
