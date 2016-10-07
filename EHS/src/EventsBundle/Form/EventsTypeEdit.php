<?php

namespace EventsBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichFileType;

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
            ->add('imageFile',VichFileType::class,
                array('required'=>false,
                    'label'=>'Choisissez un fichier à ajouter'))
            ->add('places', 'integer')
            ->add('address')
            ->add('tag',EntityType::class,array(
                'label'=>'Mots-clés',
                'label_attr'=>array('class'=>'checkbox-inline'),
                'class'=>'ArticleBundle:Tags',
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