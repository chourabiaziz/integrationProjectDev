<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $assurance = null;

    #[ORM\Column(length: 255)]
    private ?string $email_assurance = null;

    #[ORM\Column(length: 255)]
    private ?string $num_assurance = null;

    #[ORM\OneToMany(targetEntity: Devis::class, mappedBy: 'offre')]
    private Collection $devis;

    #[ORM\OneToMany(targetEntity: Avantage::class, mappedBy: 'offre')]
    private Collection $avantages;

    #[ORM\OneToMany(targetEntity: Contrat::class, mappedBy: 'offre')]
    private Collection $contrats;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
        $this->avantages = new ArrayCollection();
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getAssurance(): ?string
    {
        return $this->assurance;
    }

    public function setAssurance(string $assurance): static
    {
        $this->assurance = $assurance;

        return $this;
    }

    public function getEmailAssurance(): ?string
    {
        return $this->email_assurance;
    }

    public function setEmailAssurance(string $email_assurance): static
    {
        $this->email_assurance = $email_assurance;

        return $this;
    }

    public function getNumAssurance(): ?string
    {
        return $this->num_assurance;
    }

    public function setNumAssurance(string $num_assurance): static
    {
        $this->num_assurance = $num_assurance;

        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): static
    {
        if (!$this->devis->contains($devi)) {
            $this->devis->add($devi);
            $devi->setOffre($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): static
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getOffre() === $this) {
                $devi->setOffre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avantage>
     */
    public function getAvantages(): Collection
    {
        return $this->avantages;
    }

    public function addAvantage(Avantage $avantage): static
    {
        if (!$this->avantages->contains($avantage)) {
            $this->avantages->add($avantage);
            $avantage->setOffre($this);
        }

        return $this;
    }

    public function removeAvantage(Avantage $avantage): static
    {
        if ($this->avantages->removeElement($avantage)) {
            // set the owning side to null (unless already changed)
            if ($avantage->getOffre() === $this) {
                $avantage->setOffre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): static
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setOffre($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getOffre() === $this) {
                $contrat->setOffre(null);
            }
        }

        return $this;
    }
}
