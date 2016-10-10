<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;


class ResetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('email',EmailType::class,array('label'=>'Entrez votre email :'))
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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Form\Model\ResetPassword'
        ));
    }
}
