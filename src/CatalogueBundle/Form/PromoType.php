<?php

namespace CatalogueBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('description',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('dateDebut',DateType::class, ['attr'=>['class'=>'form-control']])
            ->add('dateFin',DateType::class, ['attr'=>['class'=>'form-control']])
            ->add('remise',IntegerType::class, ['attr'=>['class'=>'form-control','min' => 1 ,'max' => 99 ,]])
            ->add('produit',EntityType::class,array(
                'class'=>"CatalogueBundle:Produit",
                'choice_label'=>'nom',
                'attr'=>['class'=>'select888 form-control']
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CatalogueBundle\Entity\Promo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cataloguebundle_promo';
    }


}
