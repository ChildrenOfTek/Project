<?php

namespace EventsBundle\Form;

use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
              'label'=>'Description de l\'évènement'))
            ->add('start', 'datetime')
            ->add('end', 'datetime')
            ->add('places', 'integer')
            ->add('address')
            ->add('evtag',ChoiceType::class,array(
                'label'=>'Tags à ajouter',
                'label_attr'=>array('class'=>'checkbox-inline'),
                'choices'=>$this->fillEvtags(),
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

    private function fillEvtags() {
        //On reccup la liste des tags, on push dans un array,
        // et on renvoie à ChoiceType
        $evtags=$this->em->getRepository('EventsBundle:Evtags')->findAll();

        $evtagsLib = [];
        foreach($evtags as $evtag){
            //if($evtag->getLibelle()!=)
            $evtagsLib[$evtag->getLibelle()] = $evtag;
        }
        // var_dump($evtagsLib); die();
        return $evtagsLib;
    }
}
