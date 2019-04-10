<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 10/04/19
 * Time: 15:20
 */

namespace App\Form;


use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckPasswordSession extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', PasswordType::class, [
            'attr' => [
                'placeholder' => "Mot de passe de la séance",
                'class' => 'form-control'
            ],
            'required' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class
        ]);
    }

}