<?php

namespace App\Dto;

final class ImdbMovie
{
    public string $title;
    public \DateTimeInterface $releaseDate;
    public float $rating;
    public string $image;
    public array $genres;
}