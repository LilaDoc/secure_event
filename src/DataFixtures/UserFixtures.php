<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['email' => 'admin@test.com', 'password' => 'Admin1234!', 'roles' => ['ROLE_ADMIN'], 'prenom' => 'Admin', 'nom' => 'Test'],
            ['email' => 'user1@test.com', 'password' => 'User1234!', 'roles' => ['ROLE_USER'], 'prenom' => 'User1', 'nom' => 'Test'],
            ['email' => 'user2@test.com', 'password' => 'User1234!', 'roles' => ['ROLE_USER'], 'prenom' => 'User2', 'nom' => 'Test'],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $userData['password'])
            );
            $user->setRoles($userData['roles']);
            $user->setPrenom($userData['prenom']);
            $user->setNom($userData['nom']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
