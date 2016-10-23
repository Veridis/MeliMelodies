<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Type\TextType::class, array(
                'label' => 'Nom',
                'attr' => array(
                    'placeholder' => 'Nom et prénom',
                ),
            ))
            ->add('role', Type\TextType::class, array(
                'label' => 'Rôle',
                'attr' => array(
                    'placeholder' => 'Rôle',
                ),
            ))
            ->add('description', Type\TextareaType::class, array(
                'label' => 'Déscription',
                'attr' => array(
                    'placeholder' => 'Déscription',
                    'rows' => '12',
                ),
            ))
            ->add('archived', Type\CheckboxType::class, array(
                'label' => 'Archiver (ne plus apparaître sur la page présentation)',
                'required' => false,
            ))
            ->add('photo', Type\FileType::class , array(
                'label' => 'Photo (format carrée)',
                'mapped' => false,
            ));
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Member'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_member';
    }
}
