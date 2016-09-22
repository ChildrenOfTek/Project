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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;
use UserBundle\Entity\Article;
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
            ->add('user',EntityType::class, array('class'=>'UserBundle:User','property'=>'username'))
            ->add('dateArticle', DateType::class, array('data' => new \Datetime()))
            ->add('titreArticle')
            ->add('content',TextareaType::class,array('attr'=>array('rows'=>15)))
            ->add('datePublication',DateType::class,array('data'=> new \Datetime()))
            ->add('imageFile','vich_file',array('required'=>false))
            ->add('online')
            ->add('tag',ChoiceType::class,array('label'=>'Tags (Maintenir CTRL pour en choisir plusieurs)',
                'choices'=>$this->fillTags(),'attr'=>array('class'=>"form-control select2"),
                'choices_as_values'=>true,'expanded'=>false,'multiple'=>true
                ))
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
