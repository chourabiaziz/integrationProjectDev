<?php

namespace App\Entity;

use App\Repository\PanneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanneRepository::class)]
class Panne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;

    #[ORM\Column(length: 255)]
    private ?string $panne = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'panne')]
    private Collection $id_voiture;

    #[ORM\ManyToOne(inversedBy: 'pannes')]
    private ?Atelier $atelier = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    public function __construct()
    {
        $this->id_voiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getPanne(): ?string
    {
        return $this->panne;
    }

    public function setPanne(string $panne): static
    {
        $this->panne = $panne;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getIdVoiture(): Collection
    {
        return $this->id_voiture;
    }

    public function addIdVoiture(Voiture $idVoiture): static
    {
        if (!$this->id_voiture->contains($idVoiture)) {
            $this->id_voiture->add($idVoiture);
            $idVoiture->setPanne($this);
        }

        return $this;
    }

    public function removeIdVoiture(Voiture $idVoiture): static
    {
        if ($this->id_voiture->removeElement($idVoiture)) {
            // set the owning side to null (unless already changed)
            if ($idVoiture->getPanne() === $this) {
                $idVoiture->setPanne(null);
            }
        }

        return $this;
    }

    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    public function setAtelier(?Atelier $atelier): static
    {
        $this->atelier = $atelier;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
