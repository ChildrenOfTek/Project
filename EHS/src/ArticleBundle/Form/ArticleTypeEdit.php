<?php

namespace ArticleBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ArticleTypeEdit extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateArticle', DateType::class, array(
                'data' => new \Datetime(),
                'widget'=>'choice',
                'label'=>'Date de création'
            ))

            ->add('titreArticle',TextType::class,array(
                'label'=>'Titre de l\'article'))

            //->add('content',TextareaType::class,array(
            //    'attr'=>array('rows'=>15),
            //    'label'=>'Contenu de l\'article'))

                ->add('content','ckeditor',array(
                    'attr'=>array('rows'=>15),
                    'label'=>'Contenu de l\'article'))

            ->add('datePublication',DateTimeType::class,array(
                'data'=> new \Datetime(),
                'widget'=>'choice',
                'label'=>'Date de publication'))

            ->add('imageFile',VichFileType::class,
                array('required'=>false,
                    'label'=>'Choisissez un fichier pour remplacer',
                    'download_link' => false))
            ->add('online')
            ->add('tag',CollectionType::class,array(
                'entry_type'=>TagsType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference'=>false,

            ))
            ->add('online',CheckboxType::class, array(
                'label'=>'L\'article doit-il être mis en ligne?',
                'required'=>false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArticleBundle\Entity\Article'
        ));
    }

}
