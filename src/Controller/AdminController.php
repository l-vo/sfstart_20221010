<?php

namespace App\Controller;

use App\Form\MovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/add-movie', name: 'add_movie')]
    public function index(): Response
    {
        $form = $this->createForm(MovieType::class);

        return $this->renderForm('admin/movie.html.twig', [
            'form' => $form,
        ]);
    }
}
