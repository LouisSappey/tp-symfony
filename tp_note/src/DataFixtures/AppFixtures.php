<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;
use App\Enum\UserAccountStatusEnum;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function loadUsers(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/users.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/user.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['users'] as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
            $user->setAccountStatus(UserAccountStatusEnum::from($data['account_status']));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }
}