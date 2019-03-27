<?php


namespace App\Form;


use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('responses', CollectionType::class, [
                'entry_type' => ResponseType::class,
                'entry_options' => ['label' => true],
                'allow_add' => true,
                'prototype' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class
        ]);
    }

}