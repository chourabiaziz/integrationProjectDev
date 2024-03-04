<?php

namespace App\Entity;

use App\Repository\ConstatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;




#[ORM\Entity(repositoryClass: ConstatRepository::class)]
class Constat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    
    #[ORM\ManyToOne(inversedBy: 'constats')]
    private ?Assurance $relation_assurance = null; 

  
   /* #[ORM\Column(type: Types::DATE_MUTABLE  )]
    private ?\DateTimeInterface $date_accident = null; */

  
    #[ORM\Column(type: Types::TIME_MUTABLE , nullable:true)]
    private ?\DateTimeInterface $heure = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "entrez la localisation svp")]
    private ?string $localisation = null;

    #[ORM\Column]
    private ?bool $blesse_meme_leger = null;

    #[ORM\Column (type: 'boolean', nullable: true)]
    private ?bool $degats_autre_vehicule = null; 

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $degats_autre_objets = null;

    #[ORM\Column(length: 255)]
    private ?string $temoins = null;

 


    #[ORM\Column(length: 255)]
    private ?string $A_preneur_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $A_preneur_prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $A_preneur_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $A_preneur_codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $A_preneur_pays = null;

    #[ORM\Column(length: 255)]
    private ?string $A_preneur_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $A_vehicule_moteur_marque = null;

    #[ORM\Column(length: 255)]
    private ?string $A_vehicule_moteur_numImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $A_vehicule_moteur_paysImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $A_vehicule_remorque_numImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $A_vehicule_remorque_paysImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $A_societeAssurance_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $A_societeAssurance_numContrat = null;

    #[ORM\Column(length: 255)]
    private ?string $A_societeAssurance_numCarteVerte = null;

    #[ORM\Column(type: Types::DATE_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $A_societeAssurance_attestationValable_du = null;

    #[ORM\Column(type: Types::DATE_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $A_societeAssurance_attestationValable_au = null;


    #[ORM\Column(length: 255)]
    private ?string $A_societeAssurance_agence_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $A_societeAssurance_agence_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $A_societeAssurance_agence_pays = null;

    #[ORM\Column(length: 255)]
    private ?string $A_societeAssurance_agence_tel = null;

    #[ORM\Column]
    private ?bool $A_societeAssurance_degatsMaterielsAssureParContrat = null;

    #[ORM\Column(length: 255)]
    private ?string $A_conducteur_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $A_conducteur_prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $A_conducteur_dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $A_conducteur_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $A_conducteur_pays = null;

    #[ORM\Column(length: 255)]
    private ?string $A_conducteur_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $A_conducteur_numPermisComduite = null;

    #[ORM\Column(length: 255)]
    private ?string $A_conducteur_categorie = null;

   /* #[ORM\Column(type: Types::DATE_MUTABLE )]
    private ?\DateTimeInterface $A_conducteur_permisValableJusqua = null; */

    #[ORM\Column(length: 255)]
    private ?string $A_degats = null;

    #[ORM\Column(length: 255)]
    private ?string $A_observation = null;








    #[ORM\Column(length: 255)]
    private ?string $B_preneur_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $B_preneur_prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $B_preneur_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $B_preneur_codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $B_preneur_pays = null;

    #[ORM\Column(length: 255)]
    private ?string $B_preneur_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $B_vehicule_moteur_marque = null;

    #[ORM\Column(length: 255)]
    private ?string $B_vehicule_moteur_numImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $B_vehicule_moteur_paysImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $B_vehicule_remorque_numImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $B_vehicule_remorque_paysImmatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $B_societeAssurance_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $B_societeAssurance_numContrat = null;

    #[ORM\Column(length: 255)]
    private ?string $B_societeAssurance_numCarteVerte = null;

    #[ORM\Column(type: Types::DATE_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $B_societeAssurance_attestationValable_du = null;

    #[ORM\Column(type: Types::DATE_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $B_societeAssurance_attestationValable_au = null;


    #[ORM\Column(length: 255)]
    private ?string $B_societeAssurance_agence_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $B_societeAssurance_agence_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $B_societeAssurance_agence_pays = null;

    #[ORM\Column(length: 255)]
    private ?string $B_societeAssurance_agence_tel = null;

    #[ORM\Column]
    private ?bool $B_societeAssurance_degatsMaterielsAssureParContrat = null;

    #[ORM\Column(length: 255)]
    private ?string $B_conducteur_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $B_conducteur_prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $B_conducteur_dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $B_conducteur_adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $B_conducteur_pays = null;

    #[ORM\Column(length: 255)]
    private ?string $B_conducteur_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $B_conducteur_numPermisComduite = null;

    #[ORM\Column(length: 255)]
    private ?string $B_conducteur_categorie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE , nullable: true)]
    private ?\DateTimeInterface $B_conducteur_permisValableJusqua = null;

    #[ORM\Column(length: 255)]
    private ?string $B_degats = null;

    #[ORM\Column(length: 255)]
    private ?string $B_observation = null;

    #[ORM\Column]
    private ?bool $stationnement_arret = null;

    #[ORM\Column]
    private ?bool $quittaitStationnement_arret = null;
 
  
    #[ORM\Column]
    private ?bool $prenait_stationnement = null;

    #[ORM\Column]
    private ?bool $sortaitDun_parking_lieu = null;

    #[ORM\Column]
    private ?bool $sengageaitDun_parking_lieu = null;

    #[ORM\Column]
    private ?bool $sengageaitSurUnePlace_sensGigatoire = null;

    #[ORM\Column]
    private ?bool $roulerSurUnePlace_sensGigatoire = null;

    #[ORM\Column]
    private ?bool $heurtait_a_larriere = null;

    #[ORM\Column]
    private ?bool $roulaitDansMemeSens_sureUneFileDifferente = null;

    #[ORM\Column]
    private ?bool $changeaitFile = null;

    #[ORM\Column]
    private ?bool $doublait = null;

    #[ORM\Column]
    private ?bool $viraitDroite = null;

    #[ORM\Column(length: 255)]
    private ?bool $viraitGauche = null;

    #[ORM\Column]
    private ?bool $reculait = null;

    #[ORM\Column]
    private ?bool $empietaitSurUneVoie = null;

    #[ORM\Column]
    private ?bool $venaitDeDroite = null;

    #[ORM\Column]
    private ?bool $observationSignal = null;

    #[ORM\Column]
    private ?int $indiquationNombreCases = null;

    #[ORM\Column]
    private ?bool $Bstationnement_arret = null;

    #[ORM\Column]
    private ?bool $BquittaitStationnement_arret = null;

    #[ORM\Column]
    private ?bool $Bprenait_stationnement = null;

    #[ORM\Column]
    private ?bool $BsortaitDun_parking_lieu = null;

    #[ORM\Column]
    private ?bool $BsengageaitDun_parking_lieu = null;

    #[ORM\Column]
    private ?bool $BsengageaitSurUnePlace_sensGigatoire = null;

    #[ORM\Column]
    private ?bool $BroulerSurUnePlace_sensGigatoire = null;

    #[ORM\Column]
    private ?bool $Bheurtait_a_larriere = null;

    #[ORM\Column]
    private ?bool $BroulaitDansMemeSens_sureUneFileDifferente = null;

    #[ORM\Column]
    private ?bool $BchangeaitFile = null;

    #[ORM\Column]
    private ?bool $Bdoublait = null;

    #[ORM\Column]
    private ?bool $BviraitDroite = null;

    #[ORM\Column]
    private ?bool $BviraitGauche = null;

    #[ORM\Column]
    private ?bool $Breculait = null;

    #[ORM\Column]
    private ?bool $BempietaitSurUneVoie = null;

    #[ORM\Column]
    private ?bool $BvenaitDeDroite = null;

    #[ORM\Column]
    private ?bool $BobservationSignal = null;

    #[ORM\Column]
    private ?int $BindiquationNombreCases = null;

    #[ORM\Column(length: 255, nullable:true )]
    private string $imageFilename;

    #[ORM\ManyToOne(inversedBy: 'constats')]
    private ?User $createdby = null;


public function getRelation(): ?Assurance
{
    return $this->relation_assurance;
}

public function setRelation(?Assurance $relation_assurance): static
{
    $this->relation_assurance = $relation_assurance;

    return $this;
}

    public function getId(): ?int
    {
        return $this->id;
    }

/*
    public function getDateAccident(): ?\DateTimeInterface
    {
        return $this->date_accident;
    }

    public function setDateAccident(\DateTimeInterface $date_accident): static
    {
        $this->date_accident = $date_accident;

        return $this;
    }  */
   
   
   
   

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): static
    {
        $this->heure = $heure;

        return $this;
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

    public function isBlesseMemeLeger(): ?bool
    {
        return $this->blesse_meme_leger;
    }

    public function setBlesseMemeLeger(bool $blesse_meme_leger): static
    {
        $this->blesse_meme_leger = $blesse_meme_leger;

        return $this;
    }

    public function isDegatsAutreVehicule(): ?bool
    {
        return $this->degats_autre_vehicule;
    }

    public function setDegatsAutreVehicule(bool $degats_autre_vehicule): static
    {
        $this->degats_autre_vehicule = $degats_autre_vehicule;

        return $this;
    } 

    public function isDegatsAutreObjets(): ?bool
    {
        return $this->degats_autre_objets;
    }

    public function setDegatsAutreObjets(bool $degats_autre_objets): static
    {
        $this->degats_autre_objets = $degats_autre_objets;

        return $this;
    }

    public function getTemoins(): ?string
    {
        return $this->temoins;
    }

    public function setTemoins(string $temoins): static
    {
        $this->temoins = $temoins;

        return $this;
    }

    public function getAPreneurNom(): ?string
    {
        return $this->A_preneur_nom;
    }

    public function setAPreneurNom(string $A_preneur_nom): static
    {
        $this->A_preneur_nom = $A_preneur_nom;

        return $this;
    }

    public function getAPreneurPrenom(): ?string
    {
        return $this->A_preneur_prenom;
    }

    public function setAPreneurPrenom(string $A_preneur_prenom): static
    {
        $this->A_preneur_prenom = $A_preneur_prenom;

        return $this;
    }

    public function getAPreneurAdresse(): ?string
    {
        return $this->A_preneur_adresse;
    }

    public function setAPreneurAdresse(string $A_preneur_adresse): static
    {
        $this->A_preneur_adresse = $A_preneur_adresse;

        return $this;
    }

    public function getAPreneurCodePostal(): ?string
    {
        return $this->A_preneur_codePostal;
    }

    public function setAPreneurCodePostal(string $A_preneur_codePostal): static
    {
        $this->A_preneur_codePostal = $A_preneur_codePostal;

        return $this;
    }

    public function getAPreneurPays(): ?string
    {
        return $this->A_preneur_pays;
    }

    public function setAPreneurPays(string $A_preneur_pays): static
    {
        $this->A_preneur_pays = $A_preneur_pays;

        return $this;
    }

    public function getAPreneurTel(): ?string
    {
        return $this->A_preneur_tel;
    }

    public function setAPreneurTel(string $A_preneur_tel): static
    {
        $this->A_preneur_tel = $A_preneur_tel;

        return $this;
    }

  

    public function getAVehiculeMoteurMarque(): ?string
    {
        return $this->A_vehicule_moteur_marque;
    }

    public function setAVehiculeMoteurMarque(string $A_vehicule_moteur_marque): static
    {
        $this->A_vehicule_moteur_marque = $A_vehicule_moteur_marque;

        return $this;
    }

    public function getAVehiculeMoteurNumImmatriculation(): ?string
    {
        return $this->A_vehicule_moteur_numImmatriculation;
    }

    public function setAVehiculeMoteurNumImmatriculation(string $A_vehicule_moteur_numImmatriculation): static
    {
        $this->A_vehicule_moteur_numImmatriculation = $A_vehicule_moteur_numImmatriculation;

        return $this;
    }

    public function getAVehiculeMoteurPaysImmatriculation(): ?string
    {
        return $this->A_vehicule_moteur_paysImmatriculation;
    }

    public function setAVehiculeMoteurPaysImmatriculation(string $A_vehicule_moteur_paysImmatriculation): static
    {
        $this->A_vehicule_moteur_paysImmatriculation = $A_vehicule_moteur_paysImmatriculation;

        return $this;
    }
    
    public function getAVehiculeRemorqueNumImmatriculation(): ?string
    {
        return $this->A_vehicule_remorque_numImmatriculation;
    }

    public function setAVehiculeRemorqueNumImmatriculation(string $A_vehicule_remorque_numImmatriculation): static
    {
        $this->A_vehicule_remorque_numImmatriculation = $A_vehicule_remorque_numImmatriculation;

        return $this;
    }

    
    public function getAVehiculeRemorquePaysImmatriculation(): ?string
    {
        return $this->A_vehicule_remorque_paysImmatriculation;
    }

    public function setAVehiculeRemorquePaysImmatriculation(string $A_vehicule_remorque_paysImmatriculation): static
    {
        $this->A_vehicule_remorque_paysImmatriculation = $A_vehicule_remorque_paysImmatriculation;

        return $this;
    }



    public function getASocieteAssuranceNom(): ?string
    {
        return $this->A_societeAssurance_nom;
    }

    public function setASocieteAssuranceNom(string $A_societeAssurance_nom): static
    {
        $this->A_societeAssurance_nom = $A_societeAssurance_nom;

        return $this;
    }

    public function getASocieteAssuranceNumContrat(): ?string
    {
        return $this->A_societeAssurance_numContrat;
    }

    public function setASocieteAssuranceNumContrat(string $A_societeAssurance_numContrat): static
    {
        $this->A_societeAssurance_numContrat = $A_societeAssurance_numContrat;

        return $this;
    }

    public function getASocieteAssuranceNumCarteVerte(): ?string
    {
        return $this->A_societeAssurance_numCarteVerte;
    }

    public function setASocieteAssuranceNumCarteVerte(string $A_societeAssurance_numCarteVerte): static
    {
        $this->A_societeAssurance_numCarteVerte = $A_societeAssurance_numCarteVerte;

        return $this;
    }

    public function getASocieteAssuranceAttestationValableDu(): ?\DateTimeInterface
    {
        return $this->A_societeAssurance_attestationValable_du;
    }

    public function setASocieteAssuranceAttestationValableDu(\DateTimeInterface $A_societeAssurance_attestationValable_du): static
    {
        $this->A_societeAssurance_attestationValable_du = $A_societeAssurance_attestationValable_du ?: null;

        return $this;
    }


    public function getASocieteAssuranceAttestationValableAu(): ?\DateTimeInterface
    {
        return $this->A_societeAssurance_attestationValable_au;
    }

    public function setASocieteAssuranceAttestationValableAu(\DateTimeInterface $A_societeAssurance_attestationValable_au): static
    {
        $this->A_societeAssurance_attestationValable_au = $A_societeAssurance_attestationValable_au?: null;

        return $this;
    }

    public function getASocieteAssuranceAgenceNom(): ?string
    {
        return $this->A_societeAssurance_agence_nom;
    }

    public function setASocieteAssuranceAgenceNom(string $A_societeAssurance_agence_nom): static
    {
        $this->A_societeAssurance_agence_nom = $A_societeAssurance_agence_nom;

        return $this;
    }

    public function getASocieteAssuranceAgenceAdresse(): ?string
    {
        return $this->A_societeAssurance_agence_adresse;
    }

    public function setASocieteAssuranceAgenceAdresse(string $A_societeAssurance_agence_adresse): static
    {
        $this->A_societeAssurance_agence_adresse = $A_societeAssurance_agence_adresse;

        return $this;
    }


    public function getASocieteAssuranceAgencePays(): ?string
    {
        return $this->A_societeAssurance_agence_pays;
    }

    public function setASocieteAssuranceAgencePays(string $A_societeAssurance_agence_pays): static
    {
        $this->A_societeAssurance_agence_pays = $A_societeAssurance_agence_pays;

        return $this;
    }


    public function getASocieteAssuranceAgenceTel(): ?string
    {
        return $this->A_societeAssurance_agence_tel;
    }

    public function setASocieteAssuranceAgenceTel(string $A_societeAssurance_agence_tel): static
    {
        $this->A_societeAssurance_agence_tel = $A_societeAssurance_agence_tel;

        return $this;
    }


    public function isASocieteAssuranceDegatsMaterielsAssureParContrat(): ?bool
    {
        return $this->A_societeAssurance_degatsMaterielsAssureParContrat;
    }

    public function setASocieteAssuranceDegatsMaterielsAssureParContrat(bool $A_societeAssurance_degatsMaterielsAssureParContrat): static
    {
        $this->A_societeAssurance_degatsMaterielsAssureParContrat = $A_societeAssurance_degatsMaterielsAssureParContrat;

        return $this;
    }



    public function getAConducteurNom(): ?string
    {
        return $this->A_conducteur_nom;
    }

    public function setAConducteurNom(string $A_conducteur_nom): static
    {
        $this->A_conducteur_nom = $A_conducteur_nom;

        return $this;
    }

    public function getAConducteurPrenom(): ?string
    {
        return $this->A_conducteur_prenom;
    }

    public function setAConducteurPrenom(string $A_conducteur_prenom): static
    {
        $this->A_conducteur_prenom = $A_conducteur_prenom;

        return $this;
    }

    public function getAConducteurDateNaissance(): ?\DateTimeInterface
    {
        return $this->A_conducteur_dateNaissance;
    }

    public function setAConducteurDateNaissance(\DateTimeInterface $A_conducteur_dateNaissance): static
    {
        $this->A_conducteur_dateNaissance = $A_conducteur_dateNaissance;

        return $this;
    }

    public function getAConducteurAdresse(): ?string
    {
        return $this->A_conducteur_adresse;
    }

    public function setAConducteurAdresse(string $A_conducteur_adresse): static
    {
        $this->A_conducteur_adresse = $A_conducteur_adresse;

        return $this;
    }

    public function getAConducteurPays(): ?string
    {
        return $this->A_conducteur_pays;
    }

    public function setAConducteurPays(string $A_conducteur_pays): static
    {
        $this->A_conducteur_pays = $A_conducteur_pays;

        return $this;
    }


    public function getAConducteurTel(): ?string
    {
        return $this->A_conducteur_tel;
    }

    public function setAConducteurTel(string $A_conducteur_tel): static
    {
        $this->A_conducteur_tel = $A_conducteur_tel;

        return $this;
    }


    public function getAConducteurNumPermisComduite(): ?string
    {
        return $this->A_conducteur_numPermisComduite;
    }

    public function setAConducteurNumPermisComduite(string $A_conducteur_numPermisComduite): static
    {
        $this->A_conducteur_numPermisComduite = $A_conducteur_numPermisComduite;

        return $this;
    }

    public function getAConducteurCategorie(): ?string
    {
        return $this->A_conducteur_categorie;
    }

    public function setAConducteurCategorie(string $A_conducteur_categorie): static
    {
        $this->A_conducteur_categorie = $A_conducteur_categorie;

        return $this;
    }
    /*

    public function getAConducteurPermisValableJusqua(): ?\DateTimeInterface
    {
        return $this->A_conducteur_permisValableJusqua;
    }

    public function setAConducteurPermisValableJusqua(\DateTimeInterface $A_conducteur_permisValableJusqua): static
    {
        $this->A_conducteur_permisValableJusqua = $A_conducteur_permisValableJusqua;

        return $this;
    }
*/

    public function getADegats(): ?string
    {
        return $this->A_degats;
    }

    public function setADegats(string $A_degats): static
    {
        $this->A_degats = $A_degats;

        return $this;
    }

    public function getAObservation(): ?string
    {
        return $this->A_observation;
    }

    public function setAObservation(string $A_observation): static
    {
        $this->A_observation = $A_observation;

        return $this;
    }












    public function getBPreneurNom(): ?string
    {
        return $this->B_preneur_nom;
    }

    public function setBPreneurNom(string $B_preneur_nom): static
    {
        $this->B_preneur_nom = $B_preneur_nom;

        return $this;
    }

    public function getBPreneurPrenom(): ?string
    {
        return $this->B_preneur_prenom;
    }

    public function setBPreneurPrenom(string $B_preneur_prenom): static
    {
        $this->B_preneur_prenom = $B_preneur_prenom;

        return $this;
    }

    public function getBPreneurAdresse(): ?string
    {
        return $this->B_preneur_adresse;
    }

    public function setBPreneurAdresse(string $B_preneur_adresse): static
    {
        $this->B_preneur_adresse = $B_preneur_adresse;

        return $this;
    }

    public function getBPreneurCodePostal(): ?string
    {
        return $this->B_preneur_codePostal;
    }

    public function setBPreneurCodePostal(string $B_preneur_codePostal): static
    {
        $this->B_preneur_codePostal = $B_preneur_codePostal;

        return $this;
    }

    public function getBPreneurPays(): ?string
    {
        return $this->B_preneur_pays;
    }

    public function setBPreneurPays(string $B_preneur_pays): static
    {
        $this->B_preneur_pays = $B_preneur_pays;

        return $this;
    }

    public function getBPreneurTel(): ?string
    {
        return $this->B_preneur_tel;
    }

    public function setBPreneurTel(string $B_preneur_tel): static
    {
        $this->B_preneur_tel = $B_preneur_tel;

        return $this;
    }

    public function getBVehiculeMoteurMarque(): ?string
    {
        return $this->B_vehicule_moteur_marque;
    }

    public function setBVehiculeMoteurMarque(string $B_vehicule_moteur_marque): static
    {
        $this->B_vehicule_moteur_marque = $B_vehicule_moteur_marque;

        return $this;
    }

    public function getBVehiculeMoteurNumImmatriculation(): ?string
    {
        return $this->B_vehicule_moteur_numImmatriculation;
    }

    public function setBVehiculeMoteurNumImmatriculation(string $B_vehicule_moteur_numImmatriculation): static
    {
        $this->B_vehicule_moteur_numImmatriculation = $B_vehicule_moteur_numImmatriculation;

        return $this;
    }

    public function getBVehiculeMoteurPaysImmatriculation(): ?string
    {
        return $this->B_vehicule_moteur_paysImmatriculation;
    }

    public function setBVehiculeMoteurPaysImmatriculation(string $B_vehicule_moteur_paysImmatriculation): static
    {
        $this->B_vehicule_moteur_paysImmatriculation = $B_vehicule_moteur_paysImmatriculation;

        return $this;
    }

    public function getBVehiculeRemorqueNumImmatriculation(): ?string
    {
        return $this->B_vehicule_remorque_numImmatriculation;
    }

    public function setBVehiculeRemorqueNumImmatriculation(string $B_vehicule_remorque_numImmatriculation): static
    {
        $this->B_vehicule_remorque_numImmatriculation = $B_vehicule_remorque_numImmatriculation;

        return $this;
    }

    public function getBVehiculeRemorquePaysImmatriculation(): ?string
    {
        return $this->B_vehicule_remorque_paysImmatriculation;
    }

    public function setBVehiculeRemorquePaysImmatriculation(string $B_vehicule_remorque_paysImmatriculation): static
    {
        $this->B_vehicule_remorque_paysImmatriculation = $B_vehicule_remorque_paysImmatriculation;

        return $this;
    }

    public function getBSocieteAssuranceNom(): ?string
    {
        return $this->B_societeAssurance_nom;
    }

    public function setBSocieteAssuranceNom(string $B_societeAssurance_nom): static
    {
        $this->B_societeAssurance_nom = $B_societeAssurance_nom;

        return $this;
    }

    

    public function getBSocieteAssuranceNumContrat(): ?string
    {
        return $this->B_societeAssurance_numContrat;
    }

    public function setBSocieteAssuranceNumContrat(string $B_societeAssurance_numContrat): static
    {
        $this->B_societeAssurance_numContrat = $B_societeAssurance_numContrat;

        return $this;
    }

    public function getBSocieteAssuranceNumCarteVerte(): ?string
    {
        return $this->B_societeAssurance_numCarteVerte;
    }

    public function setBSocieteAssuranceNumCarteVerte(string $B_societeAssurance_numCarteVerte): static
    {
        $this->B_societeAssurance_numCarteVerte = $B_societeAssurance_numCarteVerte;

        return $this;
    }

    public function getBSocieteAssuranceAttestationValableDu(): ?\DateTimeInterface
    {
        return $this->B_societeAssurance_attestationValable_du;
    }

    public function setBSocieteAssuranceAttestationValableDu(\DateTimeInterface $B_societeAssurance_attestationValable_du): static
    {
        $this->B_societeAssurance_attestationValable_du = $B_societeAssurance_attestationValable_du ?: null;

        return $this;
    }

    public function getBSocieteAssuranceAttestationValableAu(): ?\DateTimeInterface
    {
        return $this->B_societeAssurance_attestationValable_au;
    }

    public function setBSocieteAssuranceAttestationValableAu(\DateTimeInterface $B_societeAssurance_attestationValable_au): static
    {
        $this->B_societeAssurance_attestationValable_au = $B_societeAssurance_attestationValable_au ?: null;

        return $this;
    }

    public function getBSocieteAssuranceAgenceNom(): ?string
    {
        return $this->B_societeAssurance_agence_nom;
    }

    public function setBSocieteAssuranceAgenceNom(string $B_societeAssurance_agence_nom): static
    {
        $this->B_societeAssurance_agence_nom = $B_societeAssurance_agence_nom;

        return $this;
    }

    public function getBSocieteAssuranceAgenceAdresse(): ?string
    {
        return $this->B_societeAssurance_agence_adresse;
    }

    public function setBSocieteAssuranceAgenceAdresse(string $B_societeAssurance_agence_adresse): static
    {
        $this->B_societeAssurance_agence_adresse = $B_societeAssurance_agence_adresse;

        return $this;
    }


    public function getBSocieteAssuranceAgencePays(): ?string
    {
        return $this->B_societeAssurance_agence_pays;
    }

    public function setBSocieteAssuranceAgencePays(string $B_societeAssurance_agence_pays): static
    {
        $this->B_societeAssurance_agence_pays = $B_societeAssurance_agence_pays;

        return $this;
    }


    public function getBSocieteAssuranceAgenceTel(): ?string
    {
        return $this->B_societeAssurance_agence_tel;
    }

    public function setBSocieteAssuranceAgenceTel(string $B_societeAssurance_agence_tel): static
    {
        $this->B_societeAssurance_agence_tel = $B_societeAssurance_agence_tel;

        return $this;
    }


    public function isBSocieteAssuranceDegatsMaterielsAssureParContrat(): ?bool
    {
        return $this->B_societeAssurance_degatsMaterielsAssureParContrat;
    }

    public function setBSocieteAssuranceDegatsMaterielsAssureParContrat(bool $B_societeAssurance_degatsMaterielsAssureParContrat): static
    {
        $this->B_societeAssurance_degatsMaterielsAssureParContrat = $B_societeAssurance_degatsMaterielsAssureParContrat;

        return $this;
    }

    public function getBConducteurNom(): ?string
    {
        return $this->B_conducteur_nom;
    }

    public function setBConducteurNom(string $B_conducteur_nom): static
    {
        $this->B_conducteur_nom = $B_conducteur_nom;

        return $this;
    }

    public function getBConducteurPrenom(): ?string
    {
        return $this->B_conducteur_prenom;
    }

    public function setBConducteurPrenom(string $B_conducteur_prenom): static
    {
        $this->B_conducteur_prenom = $B_conducteur_prenom;

        return $this;
    }

    public function getBConducteurDateNaissance(): ?\DateTimeInterface
    {
        return $this->B_conducteur_dateNaissance;
    }

    public function setBConducteurDateNaissance(\DateTimeInterface $B_conducteur_dateNaissance): static
    {
        $this->B_conducteur_dateNaissance = $B_conducteur_dateNaissance;

        return $this;
    }

    public function getBConducteurAdresse(): ?string
    {
        return $this->B_conducteur_adresse;
    }

    public function setBConducteurAdresse(string $B_conducteur_adresse): static
    {
        $this->B_conducteur_adresse = $B_conducteur_adresse;

        return $this;
    }

    public function getBConducteurPays(): ?string
    {
        return $this->B_conducteur_pays;
    }

    public function setBConducteurPays(string $B_conducteur_pays): static
    {
        $this->B_conducteur_pays = $B_conducteur_pays;

        return $this;
    }


    public function getBConducteurTel(): ?string
    {
        return $this->B_conducteur_tel;
    }

    public function setBConducteurTel(string $B_conducteur_tel): static
    {
        $this->B_conducteur_tel = $B_conducteur_tel;

        return $this;
    }


    public function getBConducteurNumPermisComduite(): ?string
    {
        return $this->B_conducteur_numPermisComduite;
    }

    public function setBConducteurNumPermisComduite(string $B_conducteur_numPermisComduite): static
    {
        $this->B_conducteur_numPermisComduite = $B_conducteur_numPermisComduite;

        return $this;
    }

    public function getBConducteurCategorie(): ?string
    {
        return $this->B_conducteur_categorie;
    }

    public function setBConducteurCategorie(string $B_conducteur_categorie): static
    {
        $this->B_conducteur_categorie = $B_conducteur_categorie;

        return $this;
    }

    public function getBConducteurPermisValableJusqua(): ?\DateTimeInterface
    {
        return $this->B_conducteur_permisValableJusqua;
    }

    public function setBConducteurPermisValableJusqua(\DateTimeInterface $B_conducteur_permisValableJusqua): static
    {
        $this->B_conducteur_permisValableJusqua = $B_conducteur_permisValableJusqua;

        return $this;
    }

    public function getBDegats(): ?string
    {
        return $this->B_degats;
    }

    public function setBDegats(string $B_degats): static
    {
        $this->B_degats = $B_degats;

        return $this;
    }

    public function getBObservation(): ?string
    {
        return $this->B_observation;
    }

    public function setBObservation(string $B_observation): static
    {
        $this->B_observation = $B_observation;

        return $this;
    }








    public function isStationnementArret(): ?bool
    {
        return $this->stationnement_arret;
    }

    public function setStationnementArret(bool $stationnement_arret): static
    {
        $this->stationnement_arret = $stationnement_arret;

        return $this;
    }

    public function isQuittaitStationnementArret(): ?bool
    {
        return $this->quittaitStationnement_arret;
    }

    public function setQuittaitStationnementArret(bool $quittaitStationnement_arret): static
    {
        $this->quittaitStationnement_arret = $quittaitStationnement_arret;

        return $this;
    }


    public function isPrenaitStationnement(): ?bool
    {
        return $this->prenait_stationnement;
    }

    public function setPrenaitStationnement(bool $prenait_stationnement): static
    {
        $this->prenait_stationnement = $prenait_stationnement;

        return $this;
    }

    
    public function isSortaitDunParkingLieu(): ?bool
    {
        return $this->sortaitDun_parking_lieu;
    }

    public function setSortaitDunParkingLieu(bool $sortaitDun_parking_lieu): static
    {
        $this->sortaitDun_parking_lieu = $sortaitDun_parking_lieu;

        return $this;
    }

    public function isSengageaitDunParkingLieu(): ?bool
    {
        return $this->sengageaitDun_parking_lieu;
    }

    public function setSengageaitDunParkingLieu(bool $sengageaitDun_parking_lieu): static
    {
        $this->sengageaitDun_parking_lieu = $sengageaitDun_parking_lieu;

        return $this;
    }

    public function isSengageaitSurUnePlaceSensGigatoire(): ?bool
    {
        return $this->sengageaitSurUnePlace_sensGigatoire;
    }

    public function setSengageaitSurUnePlaceSensGigatoire(bool $sengageaitSurUnePlace_sensGigatoire): static
    {
        $this->sengageaitSurUnePlace_sensGigatoire = $sengageaitSurUnePlace_sensGigatoire;

        return $this;
    }

    public function isRoulerSurUnePlaceSensGigatoire(): ?bool
    {
        return $this->roulerSurUnePlace_sensGigatoire;
    }

    public function setRoulerSurUnePlaceSensGigatoire(bool $roulerSurUnePlace_sensGigatoire): static
    {
        $this->roulerSurUnePlace_sensGigatoire = $roulerSurUnePlace_sensGigatoire;

        return $this;
    }

    public function isHeurtaitALarriere(): ?bool
    {
        return $this->heurtait_a_larriere;
    }

    public function setHeurtaitALarriere(bool $heurtait_a_larriere): static
    {
        $this->heurtait_a_larriere = $heurtait_a_larriere;

        return $this;
    }

    public function isRoulaitDansMemeSensSureUneFileDifferente(): ?bool
    {
        return $this->roulaitDansMemeSens_sureUneFileDifferente;
    }

    public function setRoulaitDansMemeSensSureUneFileDifferente(bool $roulaitDansMemeSens_sureUneFileDifferente): static
    {
        $this->roulaitDansMemeSens_sureUneFileDifferente = $roulaitDansMemeSens_sureUneFileDifferente;

        return $this;
    }

    public function isChangeaitFile(): ?bool
    {
        return $this->changeaitFile;
    }

    public function setChangeaitFile(bool $changeaitFile): static
    {
        $this->changeaitFile = $changeaitFile;

        return $this;
    }

    public function isDoublait(): ?bool
    {
        return $this->doublait;
    }

    public function setDoublait(bool $doublait): static
    {
        $this->doublait = $doublait;

        return $this;
    }

    public function isViraitDroite(): ?bool
    {
        return $this->viraitDroite;
    }

    public function setViraitDroite(bool $viraitDroite): static
    {
        $this->viraitDroite = $viraitDroite;

        return $this;
    }

    public function getViraitGauche(): ?bool
    {
        return $this->viraitGauche;
    }

    public function setViraitGauche(bool $viraitGauche): static
    {
        $this->viraitGauche = $viraitGauche;

        return $this;
    }

    public function isReculait(): ?bool
    {
        return $this->reculait;
    }

    public function setReculait(bool $reculait): static
    {
        $this->reculait = $reculait;

        return $this;
    }

    public function isEmpietaitSurUneVoie(): ?bool
    {
        return $this->empietaitSurUneVoie;
    }

    public function setEmpietaitSurUneVoie(bool $empietaitSurUneVoie): static
    {
        $this->empietaitSurUneVoie = $empietaitSurUneVoie;

        return $this;
    }

    public function isVenaitDeDroite(): ?bool
    {
        return $this->venaitDeDroite;
    }

    public function setVenaitDeDroite(bool $venaitDeDroite): static
    {
        $this->venaitDeDroite = $venaitDeDroite;

        return $this;
    }

    public function isObservationSignal(): ?bool
    {
        return $this->observationSignal;
    }

    public function setObservationSignal(bool $observationSignal): static
    {
        $this->observationSignal = $observationSignal;

        return $this;
    }




    public function getIndiquationNombreCases(): ?int
    {
        return $this->indiquationNombreCases;
    }

    public function setIndiquationNombreCases(int $indiquationNombreCases): static
    {
        $this->indiquationNombreCases = $indiquationNombreCases;

        return $this;
    }


     
   
   

    public function isBstationnementArret(): ?bool
    {
        return $this->Bstationnement_arret;
    }

    public function setBstationnementArret(bool $Bstationnement_arret): static
    {
        $this->Bstationnement_arret = $Bstationnement_arret;

        return $this;
    }

    public function isBquittaitStationnementArret(): ?bool
    {
        return $this->BquittaitStationnement_arret;
    }

    public function setBquittaitStationnementArret(bool $BquittaitStationnement_arret): static
    {
        $this->BquittaitStationnement_arret = $BquittaitStationnement_arret;

        return $this;
    }

    public function isBprenaitStationnement(): ?bool
    {
        return $this->Bprenait_stationnement;
    }

    public function setBprenaitStationnement(bool $Bprenait_stationnement): static
    {
        $this->Bprenait_stationnement = $Bprenait_stationnement;

        return $this;
    }

    public function isBsortaitDunParkingLieu(): ?bool
    {
        return $this->BsortaitDun_parking_lieu;
    }

    public function setBsortaitDunParkingLieu(bool $BsortaitDun_parking_lieu): static
    {
        $this->BsortaitDun_parking_lieu = $BsortaitDun_parking_lieu;

        return $this;
    }

    public function isBsengageaitDunParkingLieu(): ?bool
    {
        return $this->BsengageaitDun_parking_lieu;
    }

    public function setBsengageaitDunParkingLieu(bool $BsengageaitDun_parking_lieu): static
    {
        $this->BsengageaitDun_parking_lieu = $BsengageaitDun_parking_lieu;

        return $this;
    }

    public function isBsengageaitSurUnePlaceSensGigatoire(): ?bool
    {
        return $this->BsengageaitSurUnePlace_sensGigatoire;
    }

    public function setBsengageaitSurUnePlaceSensGigatoire(bool $BsengageaitSurUnePlace_sensGigatoire): static
    {
        $this->BsengageaitSurUnePlace_sensGigatoire = $BsengageaitSurUnePlace_sensGigatoire;

        return $this;
    }

    public function isBroulerSurUnePlaceSensGigatoire(): ?bool
    {
        return $this->BroulerSurUnePlace_sensGigatoire;
    }

    public function setBroulerSurUnePlaceSensGigatoire(bool $BroulerSurUnePlace_sensGigatoire): static
    {
        $this->BroulerSurUnePlace_sensGigatoire = $BroulerSurUnePlace_sensGigatoire;

        return $this;
    }

    public function isBheurtaitALarriere(): ?bool
    {
        return $this->Bheurtait_a_larriere;
    }

    public function setBheurtaitALarriere(bool $Bheurtait_a_larriere): static
    {
        $this->Bheurtait_a_larriere = $Bheurtait_a_larriere;

        return $this;
    }

    public function isBroulaitDansMemeSensSureUneFileDifferente(): ?bool
    {
        return $this->BroulaitDansMemeSens_sureUneFileDifferente;
    }

    public function setBroulaitDansMemeSensSureUneFileDifferente(bool $BroulaitDansMemeSens_sureUneFileDifferente): static
    {
        $this->BroulaitDansMemeSens_sureUneFileDifferente = $BroulaitDansMemeSens_sureUneFileDifferente;

        return $this;
    }

    public function isBchangeaitFile(): ?bool
    {
        return $this->BchangeaitFile;
    }

    public function setBchangeaitFile(bool $BchangeaitFile): static
    {
        $this->BchangeaitFile = $BchangeaitFile;

        return $this;
    }

    public function isBdoublait(): ?bool
    {
        return $this->Bdoublait;
    }

    public function setBdoublait(bool $Bdoublait): static
    {
        $this->Bdoublait = $Bdoublait;

        return $this;
    }

    public function isBviraitDroite(): ?bool
    {
        return $this->BviraitDroite;
    }

    public function setBviraitDroite(bool $BviraitDroite): static
    {
        $this->BviraitDroite = $BviraitDroite;

        return $this;
    }

    public function isBviraitGauche(): ?bool
    {
        return $this->BviraitGauche;
    }

    public function setBviraitGauche(bool $BviraitGauche): static
    {
        $this->BviraitGauche = $BviraitGauche;

        return $this;
    }

    public function isBreculait(): ?bool
    {
        return $this->Breculait;
    }

    public function setBreculait(bool $Breculait): static
    {
        $this->Breculait = $Breculait;

        return $this;
    }

    public function isBempietaitSurUneVoie(): ?bool
    {
        return $this->BempietaitSurUneVoie;
    }

    public function setBempietaitSurUneVoie(bool $BempietaitSurUneVoie): static
    {
        $this->BempietaitSurUneVoie = $BempietaitSurUneVoie;

        return $this;
    }

    public function isBvenaitDeDroite(): ?bool
    {
        return $this->BvenaitDeDroite;
    }

    public function setBvenaitDeDroite(bool $BvenaitDeDroite): static
    {
        $this->BvenaitDeDroite = $BvenaitDeDroite;

        return $this;
    }

    public function isBobservationSignal(): ?bool
    {
        return $this->BobservationSignal;
    }

    public function setBobservationSignal(bool $BobservationSignal): static
    {
        $this->BobservationSignal = $BobservationSignal;

        return $this;
    }

    public function isBindiquationNombreCases(): ?int
    {
        return $this->BindiquationNombreCases;
    }

    public function setBindiquationNombreCases(int $BindiquationNombreCases): static
    {
        $this->BindiquationNombreCases = $BindiquationNombreCases;

        return $this;
    }

    public function getImageFilename(): string
    {
        return $this->imageFilename ??'';
    }

    public function setImageFilename(string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

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

  

}
