<?php

namespace NewsletterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use ArticleBundle\Form\ArticleTypeEdit;

class NewsletterTypeEdit extends AbstractType
{
    private $em;
    private $id;

    public function __construct(EntityManager $em,$id){
        $this->em = $em;
        $this->id = $id;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array(
                'data' => new \Datetime(),
                'widget' => 'single_text',
                'disabled' => true
            ))
            ->add('sujet')
            ->add('texte', TextareaType::class, array(
                'attr'=>array('rows'=>15),
            ))
            ->add('article',CollectionType::class,array(
                'entry_type'=>ChoiceType::class,
                'entry_options'=>
                array(
                'choices'=>$this->getArticles(),
                'attr'=>array('class'=>CheckboxType::class),
                'choices_as_values'=>true,
                'expanded'=>true,
                'multiple'=>true
            )));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NewsletterBundle\Entity\Newsletter'
        ));
    }
    public function getArticles()
    {
        //On reccup la liste des articles, on push dans un array,
        // et on renvoie à ChoiceType
        $articles = $this->em->getRepository('NewsletterBundle:Newsletter')->findOneBy(array('id'=>$this->id))->getArticle();

var_dump($articles);die();
        $articlesTitre = [];
        foreach($articles as $article){
            $articlesTitre[$article->getTitreArticle()] = $article;
        }
        return $articlesTitre;

    }

}
