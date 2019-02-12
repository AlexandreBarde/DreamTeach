<?php

namespace App\Form;


use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'emailAddress',
                TextType::class, [
                    'attr' => [
                        'placeholder' => "xyz@email.com",
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'password',
                PasswordType::class, [
                    'attr' => [
                        'placeholder' => 'mot de passe',
                        'class' => 'form-control'
                    ]
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