<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'lastname',
                TextType::class
            )
            ->add(
                'firstname',
                TextType::class
            )
            ->add(
                'emailaddress',
                EmailType::class
            )
            ->add(
                'password',
                PasswordType::class
            )
            ->add('trainingid', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'getTitle',
                'attr' => [
                    'placeholder' => "Formation suivie...",
                    'class' => "custom-select getSchoolid"
                ],
                'choice_attr' => function(Training $training, $key, $index) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => $training->getSchoolid()->getId()];
                },
            ]);
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
