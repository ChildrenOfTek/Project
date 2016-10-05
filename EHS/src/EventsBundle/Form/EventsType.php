<?php

namespace EventsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EventsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description','ckeditor',array(
              'attr'=>array('rows'=>5),
              'label'=>'Description de l\'évènement'))
            ->add('start', 'datetime')
            ->add('end', 'datetime')
            ->add('places', 'integer')
            ->add('address')
            ->add('showcase', CheckboxType::class, array(
                'label'    => 'Afficher l\'évènement sur la page d\'accueil ?',
                'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventsBundle\Entity\Events'
        ));
    }
}
