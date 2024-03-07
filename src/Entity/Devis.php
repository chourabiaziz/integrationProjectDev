<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
 
    
 

  

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?Offre $offre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

 

    #[ORM\Column(length: 255)]
    private ?string $typeassurance = null;

    #[ORM\Column]
    private ?int $puissance = null;

    #[ORM\Column]
    private ?int $valeur = null;

    #[ORM\Column(length: 255)]
    private ?string $carburant = null;

    #[ORM\Column(length: 255 , nullable:true)]
    private ?string $security = null;

    #[ORM\Column(length: 255)]
    private ?string $utilisation = null;

    #[ORM\Column]
    private ?int $total = null;

    public function getId(): ?int
    {
        return $this->id;
    }

      
    
 
 
 
    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

   

    public function getTypeassurance(): ?string
    {
        return $this->typeassurance;
    }

    public function setTypeassurance(string $typeassurance): static
    {
        $this->typeassurance = $typeassurance;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): static
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): static
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getSecurity(): ?string
    {
        return $this->security;
    }

    public function setSecurity(string $security): static
    {
        $this->security = $security;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(string $utilisation): static
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }
}
