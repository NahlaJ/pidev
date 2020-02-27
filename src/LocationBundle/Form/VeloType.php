<?php

namespace LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeloType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('marque',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('caracteristiques',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('age',IntegerType::class, ['attr'=>['class'=>'form-control']])
            ->add('compteur',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('prix',NumberType::class, ['attr'=>['class'=>'form-control']])
            ->add('image',FileType::class,array('data_class'=>null,'required'=>false))
            ->add('etat',TextType::class, ['attr'=>['class'=>'form-control']]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LocationBundle\Entity\Velo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'locationbundle_velo';
    }


}
