<?php

namespace ReparationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeloAReparerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('marque',TextType::class,['attr'=>['class'=>'input999']])
            ->add('description',TextType::class,['attr'=>['class'=>'input999']])
            ->add('probleme',TextType::class,['attr'=>['class'=>'input999']])
            ->add('age',IntegerType::class,['attr'=>['class'=>'input999']])
            ->add('image',FileType::class,[
                'required' => false])
            ->add('status', HiddenType::class,[
                'data'=> 'Unaffected ',
            ])

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReparationBundle\Entity\VeloAReparer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reparationbundle_veloareparer';
    }


}
