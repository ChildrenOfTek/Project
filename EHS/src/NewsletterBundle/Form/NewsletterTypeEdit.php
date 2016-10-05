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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use ArticleBundle\Form\ArticleTypeEdit;


class NewsletterTypeEdit extends AbstractType
{
    private $em;
    private $id;

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
                'widget' => 'single_text',
                'disabled' => true
            ))
            ->add('sujet')
            ->add('texte', TextareaType::class, array(
                'attr'=>array('rows'=>15),
            ))
            ->add('article',EntityType::class, array(
                'class'=>'ArticleBundle:Article',
                'choice_label'=>'titreArticle',
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


}
