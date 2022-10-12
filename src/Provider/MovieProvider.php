<?php

namespace App\Provider;

use App\Dto\ImdbMovie;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class MovieProvider
{
    private HttpClientInterface $omdbapiClient;

    public function __construct(HttpClientInterface $omdbapiClient)
    {
        $this->omdbapiClient = $omdbapiClient;
    }

    public function getById(string $id): ImdbMovie
    {
        $response = $this->omdbapiClient->request('GET', '/', ['query' => ['i' => $id]]);
        $decoded = json_decode($response->getContent());
        $imdbMovie = new ImdbMovie();
        $imdbMovie->title = $decoded->Title;
        $imdbMovie->rating = $decoded->imdbRating;
        $imdbMovie->genres = explode(', ', $decoded->Genre);
        $imdbMovie->image = $decoded->Poster;
        $imdbMovie->releaseDate = new \DateTimeImmutable($decoded->Released);

        return $imdbMovie;
    }
}