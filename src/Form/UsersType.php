<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'Enter your last name...'],
                'constraints' => [
                    new NotBlank(['message' => 'Empty field.']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['placeholder' => 'Enter your first name...'],
                'constraints' => [
                    new NotBlank(['message' => 'Empty field.']),
                    new Regex([
                        'pattern' => '/\d/', // Disallow numbers
                        'match' => false,
                        'message' => 'Numbers are not allowed in this field.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Enter your email...'],
                'constraints' => [
                    new NotBlank(['message' => 'Empty field.']),
                    // You can add more email-related constraints if needed
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['placeholder' => 'Enter your password...'],
                'constraints' => [
                    new NotBlank(['message' => 'Empty field.']),
                    // You can add more password-related constraints if needed
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
