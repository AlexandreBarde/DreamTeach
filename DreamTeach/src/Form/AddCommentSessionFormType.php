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
use App\Entity\Sessioncomment;
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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AddCommentSessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('comment', TextType::class, [
                'attr' => [
                    'placeholder' => "Ajouter un commentaire...",
                    'class' => 'form-control',
                    'empty_data' => '',
                ],
                'required' => false
            ])
            ->add('note', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Noter la séance',
                    'class' => 'form-control',
                    'empty_data' => '2.5',
                    'min' => '0',
                    'max' => '5'
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sessioncomment::class
        ]);
    }

}