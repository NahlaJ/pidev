<?php

namespace ReparationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReparateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('prenom', TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('numTel', IntegerType::class, ['attr'=>['class'=>'form-control']])
            ->add('experience', IntegerType::class, ['attr'=>['class'=>'form-control']])
            ->add('image', FileType::class,['attr'=>['class'=>'input-file',
                'id'=>'file'],
                'label'=>'insert an image',
                'label_attr' => ['class' => 'alert alert-info label888' ],
                'required' => false,])
            ->add('status', HiddenType::class,[
                'data'=> 'libre',
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReparationBundle\Entity\Reparateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reparationbundle_reparateur';
    }


}
