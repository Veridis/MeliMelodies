<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', Type\TextType::class, array(
                'label' => 'Titre de la video',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Titre',
                    'maxlength' => 128,
                ),
            ))
            ->add('code', Type\TextType::class, array(
                'label' => 'Code Youtube',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Code Youtube',
                    'maxlength' => 128,
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

    public function getName()
    {
        return 'admin_bundle_video_type';
    }
}
