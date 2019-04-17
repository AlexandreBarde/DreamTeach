<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 17/04/19
 * Time: 14:37
 */

namespace App\Form;


use App\Entity\FileUpload;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadFile extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filename', FileType::class, [
                'required' => false,
                'label' => 'Image (Fichier jpg)', 'data_class' => null,
                'attr' => [
                    'class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FileUpload::class,
        ]);
    }

}