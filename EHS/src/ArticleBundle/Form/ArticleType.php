<?php

namespace ArticleBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class, array('class'=>'UserBundle:User','property'=>'username'))
            ->add('dateArticle', DateType::class, array('data' => new \Datetime()))
            ->add('titreArticle')
            ->add('content',TextareaType::class,array('attr'=>array('rows'=>15)))
            ->add('datePublication')
            ->add('imageFile','vich_file',array('required'=>false,'label'=>'Ajouter une image'))
            ->add('online')
            ->add('tag',EntityType::class,array('class'=>'ArticleBundle:Tags',
          'choice_label'=>'libelle'))
            ->add('newsletter')
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
