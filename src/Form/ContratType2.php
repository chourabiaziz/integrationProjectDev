<?php

namespace App\Form;

use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('couverture')
            ->add('prix')
             
             
            ->add('renew', ChoiceType::class, [
                'label' => 'Numéro de mois à ajouté',
                'choices' => [
                    '1 mois' => 1,
                    '2 mois' => 2,
                    '3 mois' => 3,
                    '4 mois' => 4,
                    '5 mois' => 5,
                    '6 mois' => 6,
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
