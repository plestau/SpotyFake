<?php

namespace App\Form;

use App\Entity\Disco;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('fecha_lanzamiento')
            ->add('cantante', null, array(
                'class' => 'App\Entity\Cantante',
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'placeholder' => 'Seleccione un cantante'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disco::class,
        ]);
    }
}
