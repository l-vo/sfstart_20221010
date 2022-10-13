<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setBirthdate(new \DateTimeImmutable('1983-09-23'));

        $manager->persist($admin);

        $alice = new User();
        $alice->setUsername('alice');
        $alice->setPassword($this->userPasswordHasher->hashPassword($alice, 'alice'));
        $alice->setRoles(['ROLE_USER']);
        $alice->setBirthdate(new \DateTimeImmutable('2000-12-14'));

        $manager->persist($alice);

        $alfred = new User();
        $alfred->setUsername('alfred');
        $alfred->setPassword($this->userPasswordHasher->hashPassword($alfred, 'alfred'));
        $alfred->setRoles(['ROLE_USER']);
        $alfred->setBirthdate(new \DateTimeImmutable('2006-05-11'));

        $manager->persist($alfred);

        $bob = new User();
        $bob->setUsername('bob');
        $bob->setPassword($this->userPasswordHasher->hashPassword($bob, 'bob'));
        $bob->setRoles(['ROLE_USER']);
        $bob->setBirthdate(new \DateTimeImmutable('2008-07-12'));

        $manager->persist($bob);

        $marc = new User();
        $marc->setUsername('marc');
        $marc->setPassword($this->userPasswordHasher->hashPassword($marc, 'marc'));
        $marc->setRoles(['ROLE_USER']);
        $marc->setBirthdate(new \DateTimeImmutable('2016-03-07'));

        $manager->persist($marc);

        $manager->flush();
    }
}