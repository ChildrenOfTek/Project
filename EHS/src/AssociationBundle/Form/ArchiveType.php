<?php

namespace AssociationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArchiveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreArchive',TextType::class,array(
                'label'=>'Titre de l\'archive'))

            ->add('dateCreation',DateType::class,array(
                'data'=> new \Datetime('now'),
                'widget'=>'choice',
                'format'=>'dd-MM-yyyy',
                'label'=>'Date de création'))

            ->add('imageFile',VichFileType::class,
                array('required'=>false,
                    'download_link' => false,
                    'label'=>'Choisissez un fichier pour remplacer'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AssociationBundle\Entity\Archive'
        ));
    }
}
