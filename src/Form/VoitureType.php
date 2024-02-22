<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir la marque de la voiture.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La marque ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('modele', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le modèle de la voiture.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le modèle ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('annee_fabrication', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir l\'année de fabrication de la voiture.']),
                    new Type([
                        'type' => 'numeric',
                        'message' => 'L\'année de fabrication doit être un nombre.'
                    ]),
                ],
            ])
            ->add('numero_serie', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le numéro de série de la voiture.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le numéro de série ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('type_carburant', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le type de carburant de la voiture.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le type de carburant ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('numero_immatriculation', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le numéro d\'immatriculation de la voiture.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le numéro d\'immatriculation ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('kilometrage', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le kilométrage de la voiture.']),
                    new Type(['type' => 'numeric', 'message' => 'Le kilométrage doit être un nombre.']),
                ],
            ])
            ->add('couleur', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir la couleur de la voiture.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La couleur ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('prix_achat', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le prix d\'achat de la voiture.']),
                    new Type(['type' => 'numeric', 'message' => 'Le prix d\'achat doit être un nombre.']),
                ],
            ])
            ->add('prix_actuel', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le prix actuel de la voiture.']),
                    new Type(['type' => 'numeric', 'message' => 'Le prix actuel doit être un nombre.']),
                ],
            ])
            ->add('date_achat', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir la date d\'achat de la voiture.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
