<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class GuestBookPostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', Type\TextType::class, array(
                'label' => 'Pseudonyme',
                'attr' => array(
                    'placeholder' => 'À renseigner',
                ),
            ))
            ->add('text', Type\TextareaType::class, array(
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Laissez nous un petit mot',
                    'rows' => '8',
                ),
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\GuestBookPost'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_guestbookpost';
    }
}
