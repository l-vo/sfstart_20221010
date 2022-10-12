<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Exception\MovieNotFoundException;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route('/movie/{id<[A-Za-z0-9]+>}', name: 'app_movies', methods: 'GET')]
    public function movie(string $id, MovieProvider $movieProvider): Response
    {
        $movie = $movieProvider->getById($id);

        return $this->render('movies/movie.html.twig', [
            'movie' => $movie,
        ]);
    }
}
