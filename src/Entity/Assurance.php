<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAssurance = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseAssurance = null;

    #[ORM\Column(length: 255)]
    private ?string $codePostalAssurance = null;

    #[ORM\Column(length: 255)]
    private ?string $telAssurance = null;

    #[ORM\Column(length: 255)]
    private ?string $emailAssurance = null;

    #[ORM\OneToMany(targetEntity: Constat::class, mappedBy: 'relation')]
    private Collection $constats;

    public function __construct()
    {
        $this->constats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAssurance(): ?string
    {
        return $this->nomAssurance;
    }

    public function setNomAssurance(string $nomAssurance): static
    {
        $this->nomAssurance = $nomAssurance;

        return $this;
    }

    public function getAdresseAssurance(): ?string
    {
        return $this->adresseAssurance;
    }

    public function setAdresseAssurance(string $adresseAssurance): static
    {
        $this->adresseAssurance = $adresseAssurance;

        return $this;
    }

    public function getCodePostalAssurance(): ?string
    {
        return $this->codePostalAssurance;
    }

    public function setCodePostalAssurance(string $codePostalAssurance): static
    {
        $this->codePostalAssurance = $codePostalAssurance;

        return $this;
    }

    public function getTelAssurance(): ?string
    {
        return $this->telAssurance;
    }

    public function setTelAssurance(string $telAssurance): static
    {
        $this->telAssurance = $telAssurance;

        return $this;
    }

    public function getEmailAssurance(): ?string
    {
        return $this->emailAssurance;
    }

    public function setEmailAssurance(string $emailAssurance): static
    {
        $this->emailAssurance = $emailAssurance;

        return $this;
    }

    /**
     * @return Collection<int, Constat>
     */
    public function getConstats(): Collection
    {
        return $this->constats;
    }

    public function addConstat(Constat $constat): static
    {
        if (!$this->constats->contains($constat)) {
            $this->constats->add($constat);
            $constat->setRelation($this);
        }

        return $this;
    }

    public function removeConstat(Constat $constat): static
    {
        if ($this->constats->removeElement($constat)) {
            // set the owning side to null (unless already changed)
            if ($constat->getRelation() === $this) {
                $constat->setRelation(null);
            }
        }

        return $this;
    }
}
