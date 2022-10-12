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
    /**
     * @Route("/movie/{id<\d+>}", name="app_movies", methods={"GET"})
     */
    public function movie(Movie $movie): Response
    {
        return $this->render('movies/movie.html.twig', [
            'movie' => $movie,
        ]);
    }
}
