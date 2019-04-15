<?php


namespace App\Form;


use App\Entity\MarkingNotation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMarkingNotationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'markingAmbience',
                ChoiceType::class,
                [
                    'choices' => [
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                    ],
                    'label' => "Notez l'ambiance",
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                ]
            )
            ->add(
                'markingEfficiency',
                ChoiceType::class,
                [
                    'choices' => [
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                    ],
                    'label' => "Notez l'éfficacité de la scéance",
                    'attr' => [
                        'class' => 'custom-select',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => MarkingNotation::class,
            ]
        );
    }

}