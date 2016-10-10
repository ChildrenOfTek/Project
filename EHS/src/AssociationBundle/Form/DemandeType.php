<?php

namespace AssociationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Gregwar\CaptchaBundle\Type\CaptchaType;


class DemandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('adresse',TextType::class)
            ->add('cp',TextType::class,array('label'=>'Code Postal'),array('attr'=> array('minlength'=>'4','maxlength'=>'5')))
            ->add('ville')
            ->add('telephone',TextType::class,array('label'=>'Téléphone'),array('attr'=> array('maxlength'=>'10')))
            ->add('email',EmailType::class)
            ->add('birthDate', BirthdayType::class,array('format'=>'dd-MM-yyyy','label'=>'Date de naissance'))
            ->add('captcha', CaptchaType::class,array(
                'invalid_message'=>'Veuillez faire correspondre votre saisie',
                'reload'=>true,
                'as_url'=>true,
                'width' => 300,
                'height' => 50,
                'length' => 6,
                'label'=>'Captcha 6 caractères'
            ));
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AssociationBundle\Entity\Demande'
        ));
    }
}
