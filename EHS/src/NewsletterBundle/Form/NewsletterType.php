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

class NewsletterType extends AbstractType
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
            ->add('date', DateType::class, array(
                'data' => new \Datetime(),
                'widget' => 'single_text'
            ))
            ->add('sujet')
            ->add('texte', TextareaType::class, array(
                'attr'=>array('rows'=>15),
            ))
            ->add('article',ChoiceType::class, array(
                'label'=>'Articles à ajouter',
                'label_attr'=>array('class'=>'checkbox'),
                'choices'=>$this->fillArticles(),
                'attr'=>array('class'=>CheckboxType::class),
                'choices_as_values'=>true,
                'expanded'=>true,
                'multiple'=>true
            ));
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

    private function fillArticles() {
        //On reccup la liste des articles, on push dans un array,
        // et on renvoie à ChoiceType
        $articles = $this->em->getRepository('ArticleBundle:Article')->findNewArticles();

        $articlesTitre = [];
        foreach($articles as $article){
            $articlesTitre[$article->getTitreArticle()] = $article;
        }
        return $articlesTitre;
    }

}
