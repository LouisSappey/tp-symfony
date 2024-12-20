<?php

namespace App\Entity;

use App\Enum\UserAccountStatusEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(enumType: UserAccountStatusEnum::class)]
    private ?UserAccountStatusEnum $accountStatus = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $resetPasswordToken = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAccountStatus(): ?UserAccountStatusEnum
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(UserAccountStatusEnum $accountStatus): static
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    public function getRoles(): array
{
    // Retourne un tableau contenant les rôles de l'utilisateur
    // Exemple : si vous avez une propriété `roles` stockée en base de données
    return $this->roles ?? ['ROLE_USER'];
}

public function getUserIdentifier(): string
{
    // Retourne l'identifiant unique de l'utilisateur (par exemple, l'email)
    return $this->email;
}

public function eraseCredentials(): void
{
    // Utilisé pour nettoyer les données sensibles (non obligatoire dans un cas simple)
}

public function setRoles(array $roles): static
{
    $this->roles = $roles;

    return $this;
}

public function getResetPasswordToken(): ?string
{
    return $this->resetPasswordToken;
}

public function setResetPasswordToken(?string $resetPasswordToken): self
{
    $this->resetPasswordToken = $resetPasswordToken;
    return $this;
}
}