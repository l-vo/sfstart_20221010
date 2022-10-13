<?php

namespace App\Dto;

final class ImdbMovie
{
    public string $title;
    public \DateTimeImmutable $releaseDate;
    public float $rating;
    public string $image;
    public array $genres;
    public string $pg;
}