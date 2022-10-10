<?php

namespace App\Provider;

use App\Exception\MovieNotFoundException;

final class MovieProvider
{
    private const MOVIES = [
        ['L\'origine du mal', '2022-10-05', ['Drama', 'Thriller'], 3.6],
        ['Les Enfants des autres', '2022-09-21', ['Drama'], 3.7],
        ['Bullet train', '2022-08-03', ['Thriller'], 3.9],
    ];

    public static function getMovie(int $id): array
    {
        $movie = self::MOVIES[$id] ?? null;
        if (null === $movie) {
            throw new MovieNotFoundException(sprintf('Movie %d not found', $id));
        }

        return $movie;
    }

    public static function getTitles(): array
    {
        return array_map(static fn(array $data): string => $data[0], self::MOVIES);
    }
}