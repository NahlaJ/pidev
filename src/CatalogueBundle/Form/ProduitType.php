<?php

namespace CatalogueBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('marque',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('description',TextareaType::class, ['attr'=>['class'=>'form-control', ]])
            ->add('prix',IntegerType::class, ['attr'=>['class'=>'form-control','min' => 1 ]])
            ->add('quantite',IntegerType::class, ['attr'=>['class'=>'form-control','min' => 1]])
            ->add('taille',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('Categorie',EntityType::class,array(
                'class'=>"CatalogueBundle:Categorie",
                'choice_label'=>'nom',
                'attr'=>['class'=>'select888 form-control']
            ))
            ->add('type',ChoiceType::class, ['attr'=>['class'=>'select888 form-control'],'choices'  => [
                'Popular' => 'Popular',
                'Mountain' => 'Mountain',
                'Sport' => 'Sport',
                'Kids' => 'Kids',
                'Special' => 'Special',
            ]])
            ->add('sexe',ChoiceType::class, ['attr'=>['class'=>'select888 form-control'],'choices'  => [
                'All' => 'All',
                'Men' => 'Men',
                'Women' => 'Women',
            ]])
            ->add('image',FileType::class,['attr'=>['class'=>'input-file',
                'id'=>'file'],
                'label'=>'insert an image',
                'label_attr' => ['class' => 'alert alert-info label888' ],
                'required' => false,]
            );

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CatalogueBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cataloguebundle_produit';
    }


}
