<?php

namespace AssociationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,array('label'=>"Nom d'utilisateur"))
            ->add('email', EmailType::class)
            ->add('sujet',TextType::class)
            ->add('contenu', TextareaType::class,array('attr'=>array('rows'=>15)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                // ici nous indiquons la class Contact que le form doit utiliser
                'data_class' => 'UserBundle\Entity\Contact',
            )
        );
    }

    public function getName()
    {
        return 'contact';
    }
}