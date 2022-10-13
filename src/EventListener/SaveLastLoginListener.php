<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

#[AsEventListener(InteractiveLoginEvent::class)]
final class SaveLastLoginListener
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(InteractiveLoginEvent $event): void
    {
        $event->getAuthenticationToken()->getUser()->setLastLogin(new \DateTimeImmutable());
        $this->entityManager->flush();
    }
}