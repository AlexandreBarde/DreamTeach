<?php


namespace App\Form;


use App\Entity\Subject;
use App\Entity\Subjectlevel;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjetLevelFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'subjectid',
            EntityType::class,
            [
                'class' => Subject::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s');
                },
                'choice_label' => 'name',
                'attr' => [
                    'class'=>'custom-select'
                ]
            ]
        )
            ->add(
                'mark',
                ChoiceType::class,
                [
                    'choices' => [
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5
                    ], 'attr' => [
                        'class'=>'custom-select'
                ]]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                "data_class" => Subjectlevel::class,
            ]
        );
    }

}