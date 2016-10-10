<?php

namespace AssociationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email', EmailType::class)
            ->add('sujet',TextType::class)
            ->add('contenu', TextareaType::class,array(
                'attr'=>array('rows'=>10)))

            ->add('captcha', CaptchaType::class,array(
                'invalid_message'=>'Veuillez faire correspondre votre saisie',
                'reload'=>true,
                'as_url'=>true,
                'width' => 300,
                'height' => 100,
                'length' => 6,
                'label'=>'Captcha 6 caractères'
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                // ici nous indiquons la class Contact que le form doit utiliser
                'data_class' => 'AssociationBundle\Entity\Contact',
            )
        );
    }

    public function getName()
    {
        return 'contact';
    }
}