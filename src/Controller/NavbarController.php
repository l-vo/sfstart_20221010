<?php

namespace App\Controller;

use App\Provider\MovieProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('navbar/index.html.twig', [
            'titles' => MovieProvider::getTitles(),
        ]);
    }
}
