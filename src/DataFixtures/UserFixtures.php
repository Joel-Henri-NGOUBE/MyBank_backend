<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $newUser = new User();
        $newUser->setEmail("this@gmail.com");
        // $passwordHasher = new UserPasswordHasherInterface();
        // $hashedPassword = $passwordHasher->hashPassword(
        //     $newUser,
        //     "password"
        // );
        $newUser->setPassword("password");
        // $userRepository->upgradePassword($newUser, $hashedPassword);
        $manager->persist($newUser);
        $manager->flush();
    }
}
