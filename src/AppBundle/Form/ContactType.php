<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

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
                'constraints' => array(
                    new Constraints\NotBlank(array('message' => 'Ce champ ne peut être vide')),
                    new Constraints\Length(array(
                        'min' => 2,
                        'max' => 40,
                        'minMessage' => 'Le pseudo ne peut pas faire moins de 2 charactères',
                        'maxMessage' => 'Le pseudo ne peut pas faire plus de 40 charactères'
                    )),
                ),
            ))
            ->add('email', 'email', array(
                'label' => 'E-mail',
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'E-mail',
                ),
                'constraints' => array(
                    new Constraints\NotBlank(array('message' => 'Ce champ ne peut être vide')),
                    new Constraints\Email(array('message' => 'L\'adresse e-mail n\'est pas valide'))
                ),
            ))
            ->add('subject', 'text', array(
                'label' => 'Sujet',
                'attr' => array(
                    'placeholder' => 'Sujet',
                ),
                'constraints' => array(
                    new Constraints\NotBlank(array('message' => 'Ce champ ne peut être vide')),
                    new Constraints\Length(array(
                        'min' => 2,
                        'max' => 140,
                        'minMessage' => 'Le sujet ne peut pas faire moins de 2 charactères',
                        'maxMessage' => 'Le sujet ne peut pas faire plus de 140 charactères'
                    )),
                ),
            ))
            ->add('message', 'textarea', array(
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Message',
                ),
                'constraints' => array(
                    new Constraints\NotBlank(array('message' => 'Ce champ ne peut être vide')),
                    new Constraints\Length(array(
                        'min' => 5,
                        'minMessage' => 'Le message ne peut pas faire moins de 5 charactères',
                    )),
                ),
            ))
            ->add('attachment', 'file', array(
                'label' => 'Pièces-jointes',
                'required' => false,
                'multiple' => true,
                'mapped' => false,
                'constraints' => array(
                    new Constraints\All(array(
                        'constraints' => array(
                            new Constraints\File(array(
                                'maxSize' => '2M',
                                'mimeTypes' => array(
                                    // @TODO : définir avec Carolyne les mimeTypes
                                    'image/gif',
                                    'image/jpeg',
                                    'image/png',
                                    'application/pdf',
                                ),
                                'maxSizeMessage' => 'Le fichier est trop large ({{ size }} {{ suffix }}). Le poids max autorisé est de {{ limit }} {{ suffix }}.',
                                'mimeTypesMessage' => 'Le format {{ type }} n\'est pas accepté. Seuls les formats {{ types }} sont acceptés.',
                            )),
                        )
                    )),
                ),
            ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }
}
