<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class NewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', Type\TextType::class, array(
                'label' => 'Titre',
                'attr' => array(
                    'placeholder' => 'Titre',
                ),
            ))
            ->add('content', Type\TextareaType::class, array(
                'label' => 'News',
                'attr' => array(
                    'class' => 'summernote',
                ),
            ))
            ->add('intro', Type\TextareaType::class, array(
                'label' => 'Introduction',
                'attr' => array(
                    'placeholder' => 'Introduction courte, 4 ou 5 lignes max',
                    'rows' => '6',
                ),
            ))
            ->add('active', Type\CheckboxType::class, array(
                'label' => 'Activer la news ?',
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\News'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_news';
    }


}
