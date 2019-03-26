<?php
/**
 * Created by PhpStorm.
 * User: Chloé Lewandowski
 * Date: 26/03/2019
 * Time: 10:35
 */

namespace App\Form;


use App\Entity\Session;
use App\Entity\Student;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransferSessionRightsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $participants = $options['participants'];

        $builder
            ->add('studentid', EntityType::class,[
                'class' => Student::class,
                'query_builder' => function (EntityRepository $er) use ($participants) {
                    return $er->createQueryBuilder('s')
                        ->where('s IN (:participants)')->setParameter('participants', $participants);
                },
                'choice_label' => 'lastname'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
            'participants' => null
        ]);
    }

}