<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    private const DATA = [
        ['L\'origine du mal', '2022-10-05', ['Drama', 'Thriller'], 36, 'origine_mal.jpg'],
        ['Les Enfants des autres', '2022-09-21', ['Drama'], 37, 'enfants_autres.jpg'],
        ['Bullet train', '2022-08-03', ['Thriller'], 39, 'bullet_train.jpg'],
        ['Novembre', '2022-10-05', ['Thriller'], 41, 'novembre.jpg'],
        ['Ticket to paradise', '2022-10-05', ['Comedy', 'Romance'], 28, 'ticket_paradise.jpg'],
        ['Leila et ses frêres', '2022-08-24', ['Drama'], 41, 'leila.jpg'],
        ['Maria rêve', '2022-09-28', ['Comedy', 'Romance'], 35, 'maria_reve.jpg'],
        ['Une belle course', '2022-09-21', ['Comedy', 'Drama'], 39, 'belle_course.jpg'],
        ['Top gun: Maverick', '2022-05-25', ['Action'], 44, 'topgun.jpg'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as [$title, $releaseDate, $genres, $rating, $image]) {
            $movie = (new Movie())
                ->setTitle($title)
                ->setReleaseDate(new \DateTimeImmutable($releaseDate))
                ->setRating($rating)
                ->setImage($image)
            ;

            foreach ($genres as $genreTitle) {
                /** @var Genre $genre */
                $genre = $this->getReference(GenreFixtures::getRef($genreTitle));
                $movie->addGenre($genre);
            }

            $manager->persist($movie);
        }

        $manager->flush();
    }
}
