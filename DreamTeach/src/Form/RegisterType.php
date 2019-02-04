<?php

namespace App\Form;


use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'lastname',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Nom de famille..",
                    ],
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Prénom..",
                    ],
                ]
            )
            ->add(
                'emailaddress',
                EmailType::class,
                [
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Votre email..",
                    ],
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Mot de passe..",
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                "data_class" => Student::class,
            ]
        );
    }
}