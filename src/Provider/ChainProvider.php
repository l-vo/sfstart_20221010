<?php

namespace App\Provider;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class ChainProvider
{
    public function __construct(#[TaggedIterator('movie_provider')]array $providers)
    {

    }
}