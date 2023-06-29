<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => 'Les mots de passe doivent correspondre.',
            'first_options' => [
                'attr' => ['autocomplete' => 'new-password',
                            'class' => 'iinput',
                            // 'style' => 'border-radius: 40px'
                            ],
                'label' => "Password",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex('/[a-z]/', 'Votre mot de passe doit contenir au moins une lettre minuscule'),
                    new Regex('/[A-Z]/', 'Votre mot de passe doit contenir au moins une lettre majuscule'),
                    new Regex('/[0-9]/', 'Votre mot de passe doit contenir au moins un chiffre'),
                    new Regex('/[\$\.\!\?\^@\\/\+\*_\-]/', 'Votre mot de passe doit contenir au moins un caractère spécial([$.!?^@\/+*_-]/)'),
                    new Regex('/[\$\.\!\?\^@\\/\+\*_\-]/', 'Votre mot de passe doit contenir au moins un caractère spécial'),

                ],
            ],
            'second_options' => ['label' => 'Confirmer le Password',
            'attr' => [
                'class' => 'iinput',
                ],
            ],
           
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
