<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('navbar/index.html.twig', [
            'movies' => $movies,
        ]);
    }
}
