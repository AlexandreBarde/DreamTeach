<?php
/**
 * Created by PhpStorm.
 * User: Chloé Lewandowski
 * Date: 04/02/2019
 * Time: 17:08
 */

namespace App\Form;


use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class sessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class
        ]);
    }

}