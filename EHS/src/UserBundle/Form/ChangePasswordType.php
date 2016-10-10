<?php
namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder->add('oldPassword', PasswordType::class,array('label'=>'Mot de passe actuel:'));
    $builder->add('newPassword', RepeatedType::class, array(
    'type' => PasswordType::class,
    'invalid_message' => 'Les deux mots de passe doivent etre identiques',
    'required' => true,
    'first_options'  => array('label' => 'Nouveau mot de passe:'),
    'second_options' => array('label' => 'Confirmez le mot de passe:'),
    ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Form\Model\ChangePassword'
        ));
    }
}
