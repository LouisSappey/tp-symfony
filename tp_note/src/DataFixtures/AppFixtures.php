<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Album;
use App\Entity\Playlist;
use App\Entity\Commentaire;
use App\Entity\Artiste;
use App\Enum\UserAccountStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->loadUsers($manager);
        $this->loadAlbums($manager, $users);
        $this->loadPlaylists($manager, $users);
        $this->loadCommentaires($manager, $users);
        $this->loadArtistes($manager, $users);

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager): array
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/users.yaml');
        $fixturesData = Yaml::parseFile($filePath);
        $userEntities = [];

        foreach ($fixturesData['users'] as $data) {
            $user = new User();
            $user->setUsername($data['username'])
                 ->setEmail($data['email'])
                 ->setPassword($this->passwordHasher->hashPassword($user, $data['password']))
                 ->setAccountStatus(UserAccountStatusEnum::from($data['account_status']))
                 ->setRoles($data['roles']);

            $manager->persist($user);
            $userEntities[$data['email']] = $user;
        }

        return $userEntities;
    }

    private function loadAlbums(ObjectManager $manager, array $users)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/albums.yaml');
        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['albums'] as $data) {
            $album = new Album();
            $album->setTitle($data['title'])
                  ->setCreateBy($users[$data['created_by']]);
            $manager->persist($album);
        }
    }

    private function loadPlaylists(ObjectManager $manager, array $users)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/playlists.yaml');
        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['playlists'] as $data) {
            $playlist = new Playlist();
            $playlist->setName($data['name'])
                     ->setOwner($users[$data['owner']]);
            $manager->persist($playlist);
        }
    }

    private function loadCommentaires(ObjectManager $manager, array $users)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/commentaires.yaml');
        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['commentaires'] as $data) {
            $commentaire = new Commentaire();
            $commentaire->setContent($data['content'])
                        ->setAuthor($users[$data['author']]);
            $manager->persist($commentaire);
        }
    }

    private function loadArtistes(ObjectManager $manager, array $users)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/artistes.yaml');
        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['artistes'] as $data) {
            $artiste = new Artiste();
            $artiste->setName($data['name']);
            foreach ($data['followers'] as $followerEmail) {
                $artiste->addFollower($users[$followerEmail]);
            }
            $manager->persist($artiste);
        }
    }
}
