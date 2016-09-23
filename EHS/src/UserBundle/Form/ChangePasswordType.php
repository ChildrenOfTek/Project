<?php
namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder->add('oldPassword', 'password',array('label'=>'Entrez votre ancien mot de passe'));
    $builder->add('newPassword', 'repeated', array(
    'type' => 'password',
    'invalid_message' => 'Les deux mots de passe doivent etre identiques',
    'required' => true,
    'first_options'  => array('label' => 'Entrez votre nouveau mot de passe'),
    'second_options' => array('label' => 'Repetez le mot de passe'),
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

    public function getName()
    {
    return 'change_passwd';
}
}