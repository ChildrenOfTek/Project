<?php

namespace EventsBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;

class EventsTypeEdit extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

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
            ->add('evtag',EntityType::class,array(
                'class'=>'EventsBundle:Evtags',
                'choice_label'=>'libelle',
                'expanded'=>true,
                'multiple'=>true
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