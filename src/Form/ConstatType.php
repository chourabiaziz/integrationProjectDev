<?php

namespace App\Form;

use App\Entity\Constat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;





class ConstatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
      
        
        ->add('date_accident' )
        ->add('heure' )
        ->add('localisation')
        ->add('blesse_meme_leger')
        ->add('degats_autre_objets')
        ->add('degats_autre_vehicule')
        ->add('temoins')

        
        ->add('A_preneur_nom')
        ->add('A_preneur_prenom')
        ->add('A_preneur_adresse')
        ->add('A_preneur_codePostal')
        ->add('A_preneur_pays', ChoiceType::class, [
            'choices' => [
                'France' => 'FR',
                'Belgique' => 'BE',
                'Luxembourg' => 'LU',
                'Suisse' => 'CH',
                'Allemagne' => 'DE',
                'Italie' => 'IT',
                'Espagne' => 'ES',
                'Portugal' => 'PT',
                'Tunisie' => 'TN',

                'Autre' => 'autre',
            ]])
        ->add('A_preneur_tel')
        ->add('A_vehicule_moteur_marque')

        ->add('A_vehicule_moteur_numImmatriculation')

        ->add('A_vehicule_moteur_paysImmatriculation', ChoiceType::class, [
            'choices' => [
                'France' => 'FR',
                'Belgique' => 'BE',
                'Luxembourg' => 'LU',
                'Suisse' => 'CH',
                'Allemagne' => 'DE',
                'Italie' => 'IT',
                'Espagne' => 'ES',
                'Portugal' => 'PT',
                'Tunisie' => 'TN',

                'Autre' => 'autre',
            ]])
        ->add('A_vehicule_remorque_numImmatriculation')
     
        ->add('A_vehicule_remorque_paysImmatriculation', ChoiceType::class, [
            'choices' => [
                'France' => 'FR',
                'Belgique' => 'BE',
                'Luxembourg' => 'LU',
                'Suisse' => 'CH',
                'Allemagne' => 'DE',
                'Italie' => 'IT',
                'Espagne' => 'ES',
                'Portugal' => 'PT',
                'Tunisie' => 'TN',
                'Autre' => 'autre',
            ]])
        ->add('A_societeAssurance_nom')
        ->add('A_societeAssurance_numContrat')
        ->add('A_societeAssurance_numCarteVerte')
        ->add('A_societeAssurance_attestationValable_du')
        ->add('A_societeAssurance_attestationValable_au')
        ->add('A_societeAssurance_agence_nom')
        ->add('A_societeAssurance_agence_adresse')
        ->add('A_societeAssurance_agence_pays', ChoiceType::class, [
            'choices' => [
                'France' => 'FR',
                'Belgique' => 'BE',
                'Luxembourg' => 'LU',
                'Suisse' => 'CH',
                'Allemagne' => 'DE',
                'Italie' => 'IT',
                'Espagne' => 'ES',
                'Portugal' => 'PT',
                'Tunisie' => 'TN',

                'Autre' => 'autre',
            ]])
        ->add('A_societeAssurance_agence_tel')
        ->add('A_societeAssurance_degatsMaterielsAssureParContrat')
        ->add('A_conducteur_nom')
        ->add('A_conducteur_prenom')
        ->add('A_conducteur_dateNaissance')
        ->add('A_conducteur_adresse')
        ->add('A_conducteur_pays', ChoiceType::class, [
            'choices' => [
                'France' => 'FR',
                'Belgique' => 'BE',
                'Luxembourg' => 'LU',
                'Suisse' => 'CH',
                'Allemagne' => 'DE',
                'Italie' => 'IT',
                'Espagne' => 'ES',
                'Portugal' => 'PT',
                'Tunisie' => 'TN',

                'Autre' => 'autre',
            ]])
        ->add('A_conducteur_tel')
        ->add('A_conducteur_numPermisComduite')
        ->add('A_conducteur_categorie')
        ->add('A_conducteur_permisValableJusqua')

       

            ->add('A_degats')
            ->add('A_observation')

            ->add('B_preneur_nom')
            ->add('B_preneur_prenom')
            ->add('B_preneur_adresse')
            ->add('B_preneur_codePostal')
            ->add('B_preneur_pays', ChoiceType::class, [
                'choices' => [
                    'France' => 'FR',
                    'Belgique' => 'BE',
                    'Luxembourg' => 'LU',
                    'Suisse' => 'CH',
                    'Allemagne' => 'DE',
                    'Italie' => 'IT',
                    'Espagne' => 'ES',
                    'Portugal' => 'PT',
                    'Tunisie' => 'TN',
    
                    'Autre' => 'autre',
                ]])
            ->add('B_preneur_tel')
            ->add('B_vehicule_moteur_marque')

            ->add('B_vehicule_moteur_numImmatriculation')

            ->add('B_vehicule_moteur_paysImmatriculation', ChoiceType::class, [
                'choices' => [
                    'France' => 'FR',
                    'Belgique' => 'BE',
                    'Luxembourg' => 'LU',
                    'Suisse' => 'CH',
                    'Allemagne' => 'DE',
                    'Italie' => 'IT',
                    'Espagne' => 'ES',
                    'Portugal' => 'PT',
                    'Tunisie' => 'TN',
    
                    'Autre' => 'autre',
                ]])
            ->add('B_vehicule_remorque_numImmatriculation')
         
            ->add('B_vehicule_remorque_paysImmatriculation', ChoiceType::class, [
                'choices' => [
                    'France' => 'FR',
                    'Belgique' => 'BE',
                    'Luxembourg' => 'LU',
                    'Suisse' => 'CH',
                    'Allemagne' => 'DE',
                    'Italie' => 'IT',
                    'Espagne' => 'ES',
                    'Portugal' => 'PT',
                    'Tunisie' => 'TN',
                    'Autre' => 'autre',
                ]])
            ->add('B_societeAssurance_nom')
            ->add('B_societeAssurance_numContrat')
            ->add('B_societeAssurance_numCarteVerte')
            ->add('B_societeAssurance_attestationValable_du')
            ->add('B_societeAssurance_attestationValable_au')
            ->add('B_societeAssurance_agence_nom')
            ->add('B_societeAssurance_agence_adresse')
            ->add('B_societeAssurance_agence_pays', ChoiceType::class, [
                'choices' => [
                    'France' => 'FR',
                    'Belgique' => 'BE',
                    'Luxembourg' => 'LU',
                    'Suisse' => 'CH',
                    'Allemagne' => 'DE',
                    'Italie' => 'IT',
                    'Espagne' => 'ES',
                    'Portugal' => 'PT',
                    'Tunisie' => 'TN',
    
                    'Autre' => 'autre',
                ]])
            ->add('B_societeAssurance_agence_tel')
            ->add('B_societeAssurance_degatsMaterielsAssureParContrat')
            ->add('B_conducteur_nom')
            ->add('B_conducteur_prenom')
            ->add('B_conducteur_dateNaissance')
            ->add('B_conducteur_adresse')
            ->add('B_conducteur_pays', ChoiceType::class, [
                'choices' => [
                    'France' => 'FR',
                    'Belgique' => 'BE',
                    'Luxembourg' => 'LU',
                    'Suisse' => 'CH',
                    'Allemagne' => 'DE',
                    'Italie' => 'IT',
                    'Espagne' => 'ES',
                    'Portugal' => 'PT',
                    'Tunisie' => 'TN',
    
                    'Autre' => 'autre',
                ]])
            ->add('B_conducteur_tel')
            ->add('B_conducteur_numPermisComduite')
            ->add('B_conducteur_categorie')
            ->add('B_conducteur_permisValableJusqua')

            ->add('B_degats')
            ->add('B_observation')


          ->add('stationnement_arret' )
            ->add('quittaitStationnement_arret')
            ->add('prenait_stationnement')
            ->add('sortaitDun_parking_lieu')
            ->add('sengageaitDun_parking_lieu')
            ->add('sengageaitSurUnePlace_sensGigatoire')
            ->add('roulerSurUnePlace_sensGigatoire')
            ->add('heurtait_a_larriere')
            ->add('roulaitDansMemeSens_sureUneFileDifferente')
            ->add('changeaitFile')
            ->add('doublait')
            ->add('viraitDroite')
            ->add('viraitGauche')
            ->add('reculait')
            ->add('empietaitSurUneVoie')
            ->add('venaitDeDroite')
            ->add('observationSignal')
            ->add('indiquationNombreCases')

            ->add('Bstationnement_arret')
            ->add('BquittaitStationnement_arret')
            ->add('Bprenait_stationnement')
            ->add('BsortaitDun_parking_lieu')
            ->add('BsengageaitDun_parking_lieu')
            ->add('BsengageaitSurUnePlace_sensGigatoire')
            ->add('BroulerSurUnePlace_sensGigatoire')
            ->add('Bheurtait_a_larriere')
            ->add('BroulaitDansMemeSens_sureUneFileDifferente')
            ->add('BchangeaitFile')
            ->add('Bdoublait')
            ->add('BviraitDroite')
            ->add('BviraitGauche')
            ->add('Breculait')
            ->add('BempietaitSurUneVoie')
            ->add('BvenaitDeDroite')
            ->add('BobservationSignal')
            ->add('BindiquationNombreCases')

            ->add('photo', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' =>[
                new Image(['maxSize' => '5000k'])
                ]
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Constat::class,
        ]);
    }
}
