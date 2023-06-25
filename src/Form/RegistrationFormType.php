<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom :',
            'constraints' => [
                new Regex([
                    'pattern' => '/^[a-zA-Z\s]+$/',
                    'message' => 'Votre nom doit contenir uniquement des lettres',
                ]),
            ],
        ])
        ->add('firstname', TextType::class, [
            'label' => 'Prénom :',
            'constraints' => [
                new Regex([
                    'pattern' => '/^[a-zA-Z\s]+$/',
                    'message' => 'Votre prenom doit contenir uniquement des lettres',
                ]),
            ],
        ])
        ->add('email', EmailType::class, [
            'attr' => ['class' => 'form-control', 'id' => 'email'],
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire.',
                ]),
                new Email([
                    'message' => 'Veuillez entrer une adresse email valide.',
                ]),
            ],
        ])
        ->add('tel', TelType::class, [
            'label' => 'Téléphone :',
            'constraints' => [
                new Regex([
                    'pattern' => '/^(0|\+33)[1-9]( ?\d{2}){4}$/',
                    'message' => 'Veuillez entrer un numéro de téléphone valide.',
                ]),
            ],
        ])
        ->add('password', PasswordType::class, [
            'mapped' => false,
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
                        'minMessage' => 'Votre mot de passe de contenier {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex('/[a-z]/', 'Votre mot de passe doit contenir au moins une lettre minuscule'),
                    new Regex('/[A-Z]/', 'Votre mot de passe doit contenir au moins une lettre majuscule'),
                    new Regex('/[0-9]/', 'Votre mot de passe doit contenir au moins un chiffre'),
                    new Regex('/[\$\.\!\?\^@\\/\+\*_\-]/', 'Votre mot de passe doit contenir au moins un caractère spécial([$.!?^@\/+*_-]/)'),
                    new Regex('/[\$\.\!\?\^@\\/\+\*_\-]/', 'Votre mot de passe doit contenir au moins un caractère spécial'),
            ],
        ],)
        ->add('RGPD', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ])
        ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
