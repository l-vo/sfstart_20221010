<?php

namespace App\EventListener;

use App\Event\MovieUpdatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class LogUpdatedMovieSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {}

    public function onMovieUpdated(MovieUpdatedEvent $event): void
    {
        $this->logger->info('Movie {movieId} updated', ['movieId' => $event->movie->getId()]);
    }

    public static function getSubscribedEvents()
    {
        return [MovieUpdatedEvent::class => 'onMovieUpdated'];
    }
}