<?php

namespace App\Command;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Provider\MovieProvider;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
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
        $output->getFormatter()->setStyle('success', new OutputFormatterStyle('black', 'green'));

        $displayTable = $output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE;
        if ($displayTable) {
            $table = new Table($output->section());
            $table->setHeaders(['Id', 'Title', 'Rating', 'Genres', 'ReleaseDate']);
            $table->render();
        }

        $notLoadedMovieIds = [];
        foreach (self::MOVIE_IDS as $id) {
            try {
                $imdbMovie = $this->movieProvider->getById($id);
            } catch (\Exception $e) {
                $notLoadedMovieIds[] = $id;
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

            if ($displayTable) {
                $table->appendRow([
                    $id,
                    $movie->getTitle(),
                    $this->formatRating($movie->getRating(), $output),
                    implode(', ', $movie->getGenres()->toArray()),
                    $movie->getReleaseDate()->format(\DateTimeInterface::RFC822),
                ]);
            }
        }

        $this->entityManager->flush();

        foreach ($notLoadedMovieIds as $id) {
            $io->warning(sprintf('Movie %s not loaded.', $id));
        }

        $io->success('Movies successfully loaded in database');

        return Command::SUCCESS;
    }

    private function formatRating(int $rating, OutputInterface $output): string
    {
        $ratingFormatted = number_format($rating / 10, 1);

        if ($ratingFormatted >= 8) {
            $ratingFormatted = sprintf('<success>%s</>', $ratingFormatted);
        } elseif ($ratingFormatted < 5) {
            $ratingFormatted = sprintf('<error>%s</>', $ratingFormatted);
        }

        return $ratingFormatted;
    }
}
