<?php

namespace App\Form;

use App\Entity\Cancion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('genero')
            ->add('duracion')
            ->add('cantante', null, array(
                'class' => 'App\Entity\Cantante',
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'placeholder' => 'Seleccione un cantante'
            ))
            ->add('disco', null, array(
                'class' => 'App\Entity\Disco',
                'choice_label' => 'titulo',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'placeholder' => 'Seleccione un disco'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cancion::class,
        ]);
    }
}
