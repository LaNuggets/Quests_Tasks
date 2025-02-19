<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\ManyToOne(targetEntity: Groupe::class, inversedBy: 'utilisateurs')]
    private ?Groupe $groupe = null;

    /**
     * @var Collection<int, HistoriqueScore>
     */
    #[ORM\OneToMany(targetEntity: HistoriqueScore::class, mappedBy: 'utilisateur')]
    private Collection $historiqueScores;

    /**
     * @var Collection<int, Invitation>
     */
    #[ORM\OneToMany(targetEntity: Invitation::class, mappedBy: 'emetteur')]
    private Collection $invitations;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'utilisateur')]
    private Collection $notifications;

    /**
     * @var Collection<int, Habitude>
     */
    #[ORM\OneToMany(targetEntity: Habitude::class, mappedBy: 'createur')]
    private Collection $habitudes;

    public function __construct()
    {
        $this->historiqueScores = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->habitudes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

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

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): static
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getGroupeFromUser(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupeFromUser(?Groupe $groupe): static
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getHistoriqueScores(): Collection
    {
        return $this->historiqueScores;
    }

    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function getHabitudes(): Collection
    {
        return $this->habitudes;
    }

    // ------------------- PARTIE SÉCURITÉ -------------------

    /**
     * Cette méthode est utilisée par Symfony pour identifier l'utilisateur
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * Cette méthode est utilisée par Symfony pour obtenir le mot de passe
     */
    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    /**
     * Cette méthode est utilisée par Symfony pour récupérer les rôles de l'utilisateur
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * Cette méthode est utilisée par Symfony pour effacer les données sensibles (si nécessaire)
     */
    public function eraseCredentials(): void
    {
        // Par exemple, effacer le plainPassword si tu en utilises un temporaire
    }
}
