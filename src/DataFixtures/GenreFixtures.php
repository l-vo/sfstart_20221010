<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Persistence\ObjectManager;

final class GenreFixtures extends MovieFixtures
{
    private const TITLES = [
        'Drama',
        'Thriller',
        'Comedy',
        'Romance',
        'Action',
    ];

    public static function getRef(string $title): string
    {
        return 'genre-'.$title;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::TITLES as $title) {
            $genre = new Genre();
            $genre->setTitle($title);
            $manager->persist($genre);

            $this->addReference(self::getRef($title), $genre);
        }

        $manager->flush();
    }
}