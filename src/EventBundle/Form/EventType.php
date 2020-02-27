<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateevent',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('lieuevent',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('nbrepersonnes',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('capevent',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('nomevent',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('description',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('ticketprice',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('eventImg', FileType::class, array(
                'data_class' => null
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Event'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventbundle_event';
    }


}
