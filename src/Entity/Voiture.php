<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column]
    private ?int $annee_fabrication = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_serie = null;

    #[ORM\Column(length: 255)]
    private ?string $type_carburant = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_immatriculation = null;

    #[ORM\Column]
    private ?int $kilometrage = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\Column]
    private ?float $prix_achat = null;

    #[ORM\Column]
    private ?float $prix_actuel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_achat = null;

    #[ORM\ManyToOne(inversedBy: 'id_voiture')]
    private ?Panne $panne = null;

    #[ORM\Column(nullable: true)]
    private ?string $carteGrise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomImage = null;


    public function __construct()
    {
        $this->pannes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getAnneeFabrication(): ?int
    {
        return $this->annee_fabrication;
    }

    public function setAnneeFabrication(int $annee_fabrication): static
    {
        $this->annee_fabrication = $annee_fabrication;

        return $this;
    }

    public function getNumeroSerie(): ?string
    {
        return $this->numero_serie;
    }

    public function setNumeroSerie(string $numero_serie): static
    {
        $this->numero_serie = $numero_serie;

        return $this;
    }

    public function getTypeCarburant(): ?string
    {
        return $this->type_carburant;
    }

    public function setTypeCarburant(string $type_carburant): static
    {
        $this->type_carburant = $type_carburant;

        return $this;
    }

    public function getNumeroImmatriculation(): ?string
    {
        return $this->numero_immatriculation;
    }

    public function setNumeroImmatriculation(string $numero_immatriculation): static
    {
        $this->numero_immatriculation = $numero_immatriculation;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prix_achat;
    }

    public function setPrixAchat(float $prix_achat): static
    {
        $this->prix_achat = $prix_achat;

        return $this;
    }

    public function getPrixActuel(): ?float
    {
        return $this->prix_actuel;
    }

    public function setPrixActuel(float $prix_actuel): static
    {
        $this->prix_actuel = $prix_actuel;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(\DateTimeInterface $date_achat): static
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    /**
     * @return Collection<int, Panne>
     */
    public function getPannes(): Collection
    {
        return $this->pannes;
    }

    public function addPanne(Panne $panne): static
    {
        if (!$this->pannes->contains($panne)) {
            $this->pannes->add($panne);
            $panne->setIdVoiture($this);
        }

        return $this;
    }

    public function removePanne(Panne $panne): static
    {
        if ($this->pannes->removeElement($panne)) {
            // set the owning side to null (unless already changed)
            if ($panne->getIdVoiture() === $this) {
                $panne->setIdVoiture(null);
            }
        }

        return $this;
    }

    public function getPanne(): ?Panne
    {
        return $this->panne;
    }

    public function setPanne(?Panne $panne): static
    {
        $this->panne = $panne;

        return $this;
    }

    public function getCarteGrise(): ?string
    {
        return $this->carteGrise;
    }

    public function setCarteGrise(?string $carteGrise): static
    {
        $this->carteGrise = $carteGrise;
    
        return $this;
    }

    public function getNomImage(): ?string
    {
        return $this->nomImage;
    }

    public function setNomImage(?string $nomImage): static
    {
        $this->nomImage = $nomImage;

        return $this;
    }
    
}
