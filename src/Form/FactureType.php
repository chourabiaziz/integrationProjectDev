<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Facture;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('client', EntityType::class, [
            'class' => User::class,
            'required'=>true,
            'choice_label' => 'email', // or any property of User entity you want to display in the dropdown
             'choices' => $this->userRepository->findAll(), // Provide choices from UserRepository
        ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
