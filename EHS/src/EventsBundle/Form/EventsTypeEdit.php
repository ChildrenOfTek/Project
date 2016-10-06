<?php

namespace EventsBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManager;

class EventsTypeEdit extends AbstractType
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
            ->add('evtag',CollectionType::class,array(
                'entry_type'=>EvtagsType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference'=>false,
            ))
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