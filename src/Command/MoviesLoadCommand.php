<?php

namespace App\Command;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Provider\MovieProvider;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:movies:load',
    description: 'Load movies into the database',
)]
class MoviesLoadCommand extends Command
{
    private const MOVIE_IDS = [
        'tt0079501',
        'tt0083866',
        'tt7869174',
        'tt0071177',
        'tt1375666',
        'tt5817168',
        'tt0076759',
        'tt4154756',
        'tt0974015',
        'tt0117571',
    ];

    public function __construct(
        private MovieProvider $movieProvider,
        private EntityManagerInterface $entityManager,
        private GenreRepository $genreRepository,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach (self::MOVIE_IDS as $id) {
            try {
                $imdbMovie = $this->movieProvider->getById($id);
            } catch (\Exception $e) {
                $io->warning(sprintf('Movie %s not loaded.', $id));
                continue;
            }

            $movie = new Movie();
            $movie->setTitle($imdbMovie->title);
            $movie->setImage($imdbMovie->image);
            $movie->setRating($imdbMovie->rating * 10);
            $movie->setReleaseDate($imdbMovie->releaseDate);

            foreach ($imdbMovie->genres as $genreTitle) {
                $genre = $this->genreRepository->findOneByTitle($genreTitle);
                if (null === $genre) {
                    $genre = new Genre();
                    $genre->setTitle($genreTitle);
                    $this->entityManager->persist($genre);
                }
                $movie->addGenre($genre);
            }

            $this->entityManager->persist($movie);
        }

        $this->entityManager->flush();

        $io->success('Movies successfully loaded in database');

        return Command::SUCCESS;
    }
}
