<?php
/**
 * Created by PhpStorm.
 * User: Chloé Lewandowski
 * Date: 04/02/2019
 * Time: 17:08
 */

namespace App\Form;


use App\Entity\Session;
use App\Entity\Subject;
use DateTime;
use DateTimeZone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));

        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => "Nom de la séance...",
                    'class' => 'form-control'
                ]
            ])
            ->add('subjectid', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'getName',

                'attr' => [
                    'placeholder' => "Matière étudiée...",
                    'class' => "custom-select"

                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Description..",
                    'class' => 'form-control'

                ]
            ])
            ->add('startingTime', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => "Heure de début...",
                    'class' => 'form-control'
                ]
            ])
            ->add('endingTime', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => "Heure de fin...",
                    'class' => 'form-control'
                ]
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => [

                    'placeholder' => "Date...",
                    'class' => 'form-control',
                    'min' => $now->format("Y-m-d")
                ]
            ])
            ->add('isVirtual', CheckboxType::class)
            ->add('maxnbparticipant', NumberType::class, [
                'attr' => [

                    'placeholder' => "Nombre max de participants...",
                    'class' => 'form-control'
                ]
            ])
            ->add('vocalSoftware', TextType::class, [
                'attr' => [
                    'placeholder' => "Logiciel vocal...",
                    'class' => 'form-control',
                    'disabled' => 'true'
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => "Ville...",
                    'class' => 'form-control',

                ]
            ])
            ->add('place', TextType::class, [
                'attr' => [
                    'placeholder' => "Etablissement...",
                    'class' => 'form-control',

                ]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class
        ]);
    }

}