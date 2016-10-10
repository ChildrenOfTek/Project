<?php

namespace EventsBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            ->add('title','text',array('label'=>'Titre'))
            ->add('description','ckeditor',array(
              'attr'=>array('rows'=>5),
              'label'=>'Présentation de l\'évènement'))
            ->add('start', DateTimeType::class, array(
                'widget'=>'choice',
                'label'=>'Début de l\'évènement'
            ))
            ->add('end', DateTimeType::class, array(
                'widget'=>'choice',
                'label'=>'Fin de l\'évènement'
            ))
            ->add('imageFile',VichFileType::class,
                array('required'=>false,
                    'label'=>'Choisissez un fichier à ajouter',
                    'download_link'=>false))
            ->add('places', 'integer',array('label'=>'Nombre de places'))
            ->add('address','text',array('label'=>'Adresse'))
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