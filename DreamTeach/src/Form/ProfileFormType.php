<?php
/**
 * Created by PhpStorm.
 * User: Chloé Lewandowski
 * Date: 04/02/2019
 * Time: 17:08
 */

namespace App\Form;


use App\Entity\Student;
use App\Entity\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control']
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control']
            ])
            ->add('biography', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control']
            ])
            ->add('emailAddress', TextType::class, [
                'attr' => [
                    'class' => 'form-control']
            ])
            ->add('trainingID', EntityType::class, [
                'choice_label' => 'getTitle',
                'class' => Training::class,
                'attr' => [
                    'class' => "custom-select"]
            ])
            ->add('birthDate', DateType::class, [

                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'],
                'format' => 'yyyy-MM-dd'
            ])
            ->add('avatar', FileType::class, [

                'required' => false,
                'label' => 'Image (Fichier jpg)', 'data_class' => null,
                'attr' => [
                    'class' => 'form-control']
            ])
            ->add('city', TextType::class, [

                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    ]
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class
        ]);
    }

}