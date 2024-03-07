<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\User;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
      /*  ->add('client', EntityType::class, [
            // Autres options de champ
            'class' => User::class, // Remplacez VotreClasseEntite par la classe de votre entité
            'constraints' => [
                new NotNull()
            ]
        ])*/

             ->add('couverture')
             ->add('dateDebut')
               ->add('engagement', ChoiceType::class, [
            'required' => true,

            'choices' => [
                '6 mois' => 6,
                '12 mois' => 12,
            ],
         ])           
         ->add('description')

          //  ->add('createdBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
