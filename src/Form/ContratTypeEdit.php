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

class ContratTypeEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
             ->add('couverture')
             ->add('dateDebut')
             ->add('dateFin')
             ->add('prix')
               ->add('engagement', ChoiceType::class, [
            'required' => true,

            'choices' => [
                '6 mois' => 6,
                '12 mois' => 12,
            ],
         ])           
 
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
