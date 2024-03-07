<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom Assurance doit être non vide")]
    #[Assert\Length(
        min: 5,
        minMessage: "Entrer un nom Assurance d'au moins 5 caractères"
    )]
    private ?string $nomAssurance = null;



    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse doit être non vide")]
    #[Assert\Length(
        min: 5,
        minMessage: "Entrer une adresse  d'au moins 5 caractères"
    )]
    private ?string $adresseAssurance = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le code postal doit être non vide")]
    #[Assert\Regex(
    pattern :"/^\d{4}$/",
    message :"Le code postal doit être un nombre de 4 chiffres."
)]
    private ?string $codePostalAssurance = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message :"Le numéro de téléphone ne peut pas être vide.")]
     #[Assert\Regex(
    pattern :"/^\d{8}$/",
    message :"Le numéro de téléphone doit contenir exactement 8 chiffres."
)]
    private ?string $telAssurance = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"L'adresse e-mail ne peut pas être vide.")]
    #[Assert\Email(
    message:"L'adresse e-mail '{{ value }}' n'est pas une adresse e-mail valide."
)]
    private ?string $emailAssurance = null;

    #[ORM\OneToMany(targetEntity: Constat::class, mappedBy: 'relation')]
    private Collection $constats;

    #[ORM\ManyToOne(inversedBy: 'assurances')]
    private ?User $createdby = null;

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


    public function getCreatedby(): ?User
    {
        return $this->createdby;
    }

    public function setCreatedby(?User $createdby): static
    {
        $this->createdby = $createdby;

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

    public function __toString()
    {
        return $this->nomAssurance ;
    }
}
