<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

#[AsEventListener(InteractiveLoginEvent::class)]
final class SaveLastLoginListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AuthorizationCheckerInterface $authorizationChecker,
    )
    {
    }

    public function __invoke(InteractiveLoginEvent $event): void
    {
        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return;
        }

        $event->getAuthenticationToken()->getUser()->setLastLogin(new \DateTimeImmutable());
        $this->entityManager->flush();
    }
}