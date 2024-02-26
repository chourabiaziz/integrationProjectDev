<?php

namespace App\Form;

use App\Entity\Assurance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints as Assert;

class AssuranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomAssurance', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Vous devez indiquer le nom de l\'assurance.',
                ]),
                new Assert\Length(['min' => 5, 'max' => 255]),
            ],
        ])
        ->add('adresseAssurance', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Vous devez indiquer l\'adresse de l\'assurance.',
                ]),
                new Assert\Length(['min' => 5, 'max' => 255]),
            ],
        ])

        ->add('codePostalAssurance', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Vous devez indiquer le code postal de l\'assurance.',
                ]),
                new Assert\Length(['min' => 5, 'max' => 5]),
            ],
        ])
        ->add('telAssurance', TelType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Vous devez indiquer le numéro de téléphone de l\'assurance.',
                ]),
                new Assert\Length(['min' => 10, 'max' => 15]),
            ],
        ])

        ->add('emailAssurance', EmailType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Vous devez indiquer l\'adresse e-mail de l\'assurance.',
                ]),
                new Assert\Email(),
            ],
        ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurance::class,
        ]);
    }
}
