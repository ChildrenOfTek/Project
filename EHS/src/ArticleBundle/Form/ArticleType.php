<?php

namespace ArticleBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;

class ArticleType extends AbstractType
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

            ->add('dateArticle', DateType::class, array(
                'data' => new \Datetime(),
                'widget'=>'choice',
                'format'=>'dd-MM-yyyy',
                'label'=>'Date de création'

            ))

            ->add('titreArticle',TextType::class,array(
                'label'=>'Titre de l\'article'))

                ->add('content','ckeditor',array(
                    'attr'=>array('rows'=>15),
                    'label'=>'Contenu de l\'article'))

            ->add('datePublication',DateTimeType::class,array(
                'data'=> new \Datetime('now'),
                'widget'=>'choice',
                'format'=>'dd-MM-yyyy HH',
                'label'=>'Date de publication'))

            ->add('imageFile',VichImageType::class,
                array('required'=>false,
                    'label'=>'Choisissez un fichier à ajouter'))

            ->add('tag',EntityType::class,array(
                'class'=>'ArticleBundle:Tags',
                'choice_label'=>'libelle',
                'label'=>'Tags à ajouter',
                'attr'=>array('class'=>CheckboxType::class),
                'expanded'=>true,
                'multiple'=>true
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
