<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\Offre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
              ->add('typeassurance', ChoiceType::class, [
                'choices' => [
                    'Vol' => 'Vol',
                    'Tous risuqe' => 'Toues risque',
                    // Ajoutez d'autres options ici
                ],
                // Autres options facultatives
            ])
            ->add('puissance', NumberType::class, [
                'attr' => ['min' => 0], // Valeur minimale
            ])->add('valeur', NumberType::class, [
                    'attr' => ['min' => 5000], // Valeur minimale
                ])->add('carburant', ChoiceType::class, [
                    'choices' => [
                        'Essence' => 'essence',
                        'Diesel' => 'diesel',
                        'Gaz' => 'Gaz',
                        // Ajoutez d'autres options ici
                    ],
                    // Autres options facultatives
                ])
            ->add('utilisation', ChoiceType::class, [
                'choices' => [
                    'Personelle' => 'Personelle',
                    'Commercial' => 'Commercial',
                    'Famille' => 'Famille',
                    // Ajoutez d'autres options ici
                ],
                // Autres options facultatives
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
