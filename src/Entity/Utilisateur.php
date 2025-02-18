<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $motdepase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $string = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\Column(length: 255)]
    private ?string $groupe = null;

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

    public function getMotdepase(): ?string
    {
        return $this->motdepase;
    }

    public function setMotdepase(string $motdepase): static
    {
        $this->motdepase = $motdepase;

        return $this;
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(?string $string): static
    {
        $this->string = $string;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): static
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(string $groupe): static
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection<int, HistoriqueScore>
     */
    public function getHistoriqueScores(): Collection
    {
        return $this->historiqueScores;
    }

    public function addHistoriqueScore(HistoriqueScore $historiqueScore): static
    {
        if (!$this->historiqueScores->contains($historiqueScore)) {
            $this->historiqueScores->add($historiqueScore);
            $historiqueScore->setUtilisateur($this);
        }

        return $this;
    }

    public function removeHistoriqueScore(HistoriqueScore $historiqueScore): static
    {
        if ($this->historiqueScores->removeElement($historiqueScore)) {
            // set the owning side to null (unless already changed)
            if ($historiqueScore->getUtilisateur() === $this) {
                $historiqueScore->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): static
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations->add($invitation);
            $invitation->setEmetteur($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): static
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getEmetteur() === $this) {
                $invitation->setEmetteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setUtilisateur($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUtilisateur() === $this) {
                $notification->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Habitude>
     */
    public function getHabitudes(): Collection
    {
        return $this->habitudes;
    }

    public function addHabitude(Habitude $habitude): static
    {
        if (!$this->habitudes->contains($habitude)) {
            $this->habitudes->add($habitude);
            $habitude->setCreateur($this);
        }

        return $this;
    }

    public function removeHabitude(Habitude $habitude): static
    {
        if ($this->habitudes->removeElement($habitude)) {
            // set the owning side to null (unless already changed)
            if ($habitude->getCreateur() === $this) {
                $habitude->setCreateur(null);
            }
        }

        return $this;
    }
}
