<?php

namespace App\Security;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class PgVoter extends Voter
{
    protected function supports(string $attribute, $subject)
    {
        return $attribute === 'PG';
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        if (!$subject instanceof Movie) {
            return false;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        // https://www.classification.gov.au/classification-ratings/what-do-ratings-mean
        return match($subject->getPg()) {
            'N/A', 'G' => true,
            'PG-13' => $user->getAge() > 13,
            'PG' => $user->getAge() > 15,
            'R' => $user->getAge() > 18,
            default => throw new \LogicException(sprintf('Unknown PG: %s', $subject->getPg())),
        };
    }
}