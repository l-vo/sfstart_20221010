<?php

namespace App\Controller;

use App\Exception\MovieNotFoundException;
use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route('/movie/{id<\d+>}', name: 'app_movies', methods: 'GET')]
    public function movie(int $id, MovieRepository $movieRepository): Response
    {
        $movie = $movieRepository->find($id);
        if (null === $movie) {
            throw $this->createNotFoundException();
        }

        return $this->render('movies/movie.html.twig', [
            'movie' => $movie,
        ]);
    }
}
