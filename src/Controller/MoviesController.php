<?php

namespace App\Controller;

use App\Exception\MovieNotFoundException;
use App\Provider\MovieProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route('/movie/{id<\d+>}', name: 'app_movies', methods: 'GET')]
    public function movie(int $id): Response
    {
        try {
            $movie = MovieProvider::getMovie($id);
        } catch (MovieNotFoundException $e) {
            throw $this->createNotFoundException(null, $e);
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
