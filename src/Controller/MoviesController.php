<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private const MOVIES = [
        ['L\'origine du mal', '2022-10-05', ['Drama', 'Thriller'], 3.6],
        ['Les Enfants des autres', '2022-09-21', ['Drama'], 3.7],
        ['Bullet train', '2022-08-03', ['Thriller'], 3.9],
    ];

    #[Route('/movie/{id<\d+>}', name: 'app_movies', methods: 'GET')]
    public function movie(int $id): Response
    {
        $movie = self::MOVIES[$id] ?? null;
        if (null === $movie) {
            throw $this->createNotFoundException();
        }

        [$title, $releaseDate, $genres, $rating] = $movie;

        return $this->render('movies/movie.html.twig', [
            'title' => $title,
            'release_date' => new \DateTimeImmutable($releaseDate),
            'genres' => $genres,
            'rating' => $rating,
        ]);
    }
}
