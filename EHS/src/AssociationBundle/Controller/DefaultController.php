<?php

namespace AssociationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\ContactType;
use UserBundle\Entity\User;


/**
 * Association controller.
 * @Route("/association")
 */
class DefaultController extends Controller
{

    /* ALL ROUTES FOR ASSOCIATION PURPOSE LIKE STATUS,OFFICE...*/

    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        return $this->render('association/index.html.twig');
    }

    /**
     * @Route("/about", name="association_about")
     */
    public function aboutAction()
    {
        return $this->render('association/about.html.twig');
    }

    /**
     * @Route("/status", name="association_status")
     */
    public function statusAction()
    {
        return $this->render('association/status.html.twig');
    }

    /**
     * @Route("/office", name="association_office")
     */
    public function officeAction()
    {
        return $this->render('association/office.html.twig');
    }

    /**
     * @Route("/presentation", name="association_presentation")
     */
    public function presentationAction()
    {
        return $this->render('association/presentation.html.twig');
    }

    /* A SUIVRE ACTIONS PLUS SPECIFIQUES COMME FORMULAIRE DE CONTACT */

    /**
     * Generates a contact form.
     *
     * @Route("/contact", name="contact")
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $r)
    {

        $user=$this->get('security.context')->getToken()->getUser();

        // on créer le formulaire à partir de notre formType
        $formContact = $this->createForm(new ContactType());

        // on vérifi si c'est une méthode post
        if($r->isMethod('post')){
            // on récupére les informations du formulaire soumis et on set les différents champs de notre formulaile avec, donc la class Contact.
            $formContact->handleRequest($r);

            //on vérifi si le formulaire est valide, souvenez vous des différents validateurs que nous avons mis en place sur notre entitée contact
            if($formContact->isValid()){

                // Ici on récupére la class Contact qui a été préalablement Set avec les champs du formulaire
                $contact = $formContact->getData();

                $message = \Swift_Message::newInstance()
                    ->setSubject($contact->getSujet())
                    ->setFrom($contact->getEmail())
                    // notre adresse mail
                    ->setTo('guillossou.michele@gmail.com')
                    //->setContentType('text/html')
                    //ici nous allons utiliser un template pour pouvoir styliser notre mail si nous le souhaitons
                    ->setBody(
                        $this->renderView('association/email.html.twig', array(
                                'contact' => $contact
                            )
                        ), 'text/html'
                    )
                ;

                // nous appelons le service swiftmailer et on envoi :)
                $this->get('mailer')->send($message);

                // on retourne une message flash pour l'utilisateur pour le prévenir que son mail est bien parti
                $this->get('session')->getFlashBag()->add('success', 'Merci pour votre email !');
            }else{
                //si le formulaire n'est pas valide en plus des erreurs du form
                $this->get('session')->getFlashBag()->add('danger', 'Désolé un problème est survenu.');

            }
        }

        return $this->render('association/contact.html.twig', array(
            // on renvoi dans la vue "la vue" du formulaire
            'formContact' => $formContact->createView(),
            'user'=>$user,
        ));
    }



}
