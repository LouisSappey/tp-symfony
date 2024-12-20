<?php

namespace App\Entity;

use App\Enum\UserAccountStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Album>
     */
    #[ORM\OneToMany(targetEntity: Album::class, mappedBy: 'createBy')]
    private Collection $albums;

    /**
     * @var Collection<int, Artiste>
     */
    #[ORM\ManyToMany(targetEntity: Artiste::class, mappedBy: 'followers')]
    private Collection $followedArtists;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'owner')]
    private Collection $playlists;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'author')]
    private Collection $commentaires;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->followedArtists = new ArrayCollection();
        $this->playlists = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

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

/**
 * @return Collection<int, Album>
 */
public function getAlbums(): Collection
{
    return $this->albums;
}

public function addAlbum(Album $album): static
{
    if (!$this->albums->contains($album)) {
        $this->albums->add($album);
        $album->setCreateBy($this);
    }

    return $this;
}

public function removeAlbum(Album $album): static
{
    if ($this->albums->removeElement($album)) {
        // set the owning side to null (unless already changed)
        if ($album->getCreateBy() === $this) {
            $album->setCreateBy(null);
        }
    }

    return $this;
}

/**
 * @return Collection<int, Artiste>
 */
public function getFollowedArtists(): Collection
{
    return $this->followedArtists;
}

public function addFollowedArtist(Artiste $followedArtist): static
{
    if (!$this->followedArtists->contains($followedArtist)) {
        $this->followedArtists->add($followedArtist);
        $followedArtist->addFollower($this);
    }

    return $this;
}

public function removeFollowedArtist(Artiste $followedArtist): static
{
    if ($this->followedArtists->removeElement($followedArtist)) {
        $followedArtist->removeFollower($this);
    }

    return $this;
}

/**
 * @return Collection<int, Playlist>
 */
public function getPlaylists(): Collection
{
    return $this->playlists;
}

public function addPlaylist(Playlist $playlist): static
{
    if (!$this->playlists->contains($playlist)) {
        $this->playlists->add($playlist);
        $playlist->setOwner($this);
    }

    return $this;
}

public function removePlaylist(Playlist $playlist): static
{
    if ($this->playlists->removeElement($playlist)) {
        // set the owning side to null (unless already changed)
        if ($playlist->getOwner() === $this) {
            $playlist->setOwner(null);
        }
    }

    return $this;
}

/**
 * @return Collection<int, Commentaire>
 */
public function getCommentaires(): Collection
{
    return $this->commentaires;
}

public function addCommentaire(Commentaire $commentaire): static
{
    if (!$this->commentaires->contains($commentaire)) {
        $this->commentaires->add($commentaire);
        $commentaire->setAuthor($this);
    }

    return $this;
}

public function removeCommentaire(Commentaire $commentaire): static
{
    if ($this->commentaires->removeElement($commentaire)) {
        // set the owning side to null (unless already changed)
        if ($commentaire->getAuthor() === $this) {
            $commentaire->setAuthor(null);
        }
    }

    return $this;
}
}