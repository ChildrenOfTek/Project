<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','text',array('label'=>"Nom d'utilisateur"))
            ->add('email', 'email')
            ->add('sujet')
            ->add('contenu', 'textarea',array('attr'=>array('rows'=>15)))
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