<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Form\FileType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', 'text', array(
                'label' => 'Pseudo',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Pseudo',
                    'maxlength' => 40,
                ),
            ))
            ->add('email', 'email', array(
                'label' => 'E-mail',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'E-mail',
                ),
            ))
            ->add('subject', 'text', array(
                'label' => 'Sujet',
                'attr' => array(
                    'placeholder' => 'Sujet',
                ),
            ))
            ->add('message', 'textarea', array(
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Message',
                    'rows' => '10',
                ),
            ))
            ->add('files', 'collection', array(
                'type' => new FileType(),
                'label' => 'Pièces-jointes',
                'required' => false,
                'allow_add' => true,
            ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact',
        ));
    }
}
