<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', Type\TextType::class, array(
                'label' => 'Pseudo',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Pseudo',
                    'maxlength' => 40,
                ),
            ))
            ->add('email', Type\EmailType::class, array(
                'label' => 'E-mail',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'E-mail',
                ),
            ))
            ->add('subject', Type\TextType::class, array(
                'label' => 'Sujet',
                'attr' => array(
                    'placeholder' => 'Sujet',
                ),
            ))
            ->add('message', Type\TextareaType::class, array(
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Message',
                    'rows' => '10',
                ),
            ))
            ->add('files', Type\CollectionType::class, array(
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

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }
}
