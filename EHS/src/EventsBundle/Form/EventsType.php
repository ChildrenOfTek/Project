<?php

namespace EventsBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Doctrine\ORM\EntityManager;

class EventsType extends AbstractType
{
    // L'entity manager va nous servir a reccuperer la liste des tags existants
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
              'label'=>'Présentation de l\'évènement'))
            ->add('start',DateTimeType::class,array(
                'data'=> new \Datetime(),
                'widget'=>'choice',
                'label'=>'Début de l\'évènement'))
            ->add('end',DateTimeType::class,array(
                'data'=> new \Datetime(),
                'widget'=>'choice',
                'label'=>'Fin de l\'évènement'))
            ->add('imageFile',VichFileType::class,
                array('required'=>false,
                    'label'=>'Choisissez un fichier à ajouter'))
            ->add('places', 'integer')
            ->add('address')
            ->add('tag',ChoiceType::class,array(
                'label'=>'Tags à ajouter',
                'label_attr'=>array('class'=>'checkbox-inline'),
                'choices'=>$this->fillTags(),
                'attr'=>array('class'=>CheckboxType::class),
                'choices_as_values'=>true,
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

    private function fillTags() {
        //On reccup la liste des tags, on push dans un array,
        // et on renvoie à ChoiceType
        $tags=$this->em->getRepository('ArticleBundle:Tags')->findAll();

        $tagsLib = [];
        foreach($tags as $tag){
            //if($tag->getLibelle()!=)
            $tagsLib[$tag->getLibelle()] = $tag;
        }
        return $tagsLib;
    }
}
