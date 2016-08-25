<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use UserBundle\User;
use UserBundle\Role;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
                'attr'  => array('display' => 'hidden'),
                'property'=>'name',
                'label'=>"Role"
                ))
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('telephone')
            ->add('email')
            ->add('newsletter')
            ->add('birthDate', 'birthday',array('format'=>'dd-MM-yyyy','label'=>'Date de naissance'))
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
