<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('username','text',array('label'=>'Nom d\'utilisateur'))
            ->add('password','password',array('label'=>'Mot de passe'))
            ->add('userRoles',EntityType::class, array(
                'class'=>'UserBundle:Role',
                'choice_label'=>'name',
                'label'=>'Role à attribuer'
                ))
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('cp','text',array('attr'=> array('minlength'=>'4','maxlength'=>'5')))
            ->add('ville')
            ->add('telephone','text',array('attr'=> array('maxlength'=>'10')))
            ->add('email',EmailType::class)
            ->add('newsletter')
            ->add('birthDate', BirthdayType::class,array('format'=>'dd-MM-yyyy','label'=>'Date de naissance'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User'
        ));
    }
}
