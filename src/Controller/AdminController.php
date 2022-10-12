<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/update-movie/{id<\d+>}", name="add_movie")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, Movie $movie, SluggerInterface $slugger, string $uploadDir): Response
    {
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();
            if ($image !== null) {
                $targetFilename = $slugger->slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)).'_'.uniqid().'.'.$image->guessExtension();
                $movie->setImage($targetFilename);
                $image->move($uploadDir, $targetFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_movies', ['id' => $movie->getId()]);
        }

        return $this->renderForm('admin/movie.html.twig', [
            'form' => $form,
        ]);
    }
}
