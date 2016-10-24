<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Media;

class MediaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', Type\TextType::class, array(
                'label' => 'Titre',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Titre',
                    'maxlength' => 128,
                ),
            ))
            ->add('category', Type\ChoiceType::class, array(
                'label' => 'Categorie',
                'choices' => Media::getCategories(),
                'empty_value' => 'Selectionnez la categorie',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Media'
        ));
    }
}
