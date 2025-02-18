<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 255)]
    private ?string $chef = null;

    #[ORM\Column(length: 255)]
    private ?string $membres = null;

    /**
     * @var Collection<int, Invitation>
     */
    #[ORM\OneToMany(targetEntity: Invitation::class, mappedBy: 'groupe')]
    private Collection $invitations;

    /**
     * @var Collection<int, Habitude>
     */
    #[ORM\OneToMany(targetEntity: Habitude::class, mappedBy: 'groupe')]
    private Collection $habitudes;

    public function __construct()
    {
        $this->invitations = new ArrayCollection();
        $this->habitudes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getChef(): ?string
    {
        return $this->chef;
    }

    public function setChef(string $chef): static
    {
        $this->chef = $chef;

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
            $invitation->setGroupe($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): static
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getGroupe() === $this) {
                $invitation->setGroupe(null);
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
            $habitude->setGroupe($this);
        }

        return $this;
    }

    public function removeHabitude(Habitude $habitude): static
    {
        if ($this->habitudes->removeElement($habitude)) {
            // set the owning side to null (unless already changed)
            if ($habitude->getGroupe() === $this) {
                $habitude->setGroupe(null);
            }
        }

        return $this;
    }

    public function getMembres(){
        return $this->membres;
    }

    public function addMembre(string $membre){
        array_push($this->membres, $membre);
    }
}
