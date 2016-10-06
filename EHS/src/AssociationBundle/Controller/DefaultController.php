<?php

namespace AssociationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AssociationBundle\Form\ContactType;
use AssociationBundle\Form\DemandeType;


/**
 * Association controller.
 * @Route("/")
 */
class DefaultController extends Controller
{

    /* ALL ROUTES FOR ASSOCIATION PURPOSE LIKE STATUS,OFFICE...*/

    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findOnline();
        return $this->render('association/index.html.twig',array('articles'=>$articles));
    }

    /**
     * @Route("/association/about", name="association_about")
     */
    public function aboutAction()
    {
        return $this->render('association/about.html.twig');
    }

    /**
     * @Route("/association/status", name="association_status")
     */
    public function statusAction()
    {
        return $this->render('association/status.html.twig');
    }

    /**
     * @Route("/association/office", name="association_office")
     */
    public function officeAction()
    {
        return $this->render('association/office.html.twig');
    }

    /**
     * @Route("/association/presentation", name="association_presentation")
     */
    public function presentationAction()
    {
        return $this->render('association/presentation.html.twig');
    }

    /* A SUIVRE ACTIONS PLUS SPECIFIQUES COMME FORMULAIRE DE CONTACT */

    /**
     * Generates a contact form.
     *
     * @Route("/association/contact", name="contact")
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $r)
    {

        $user=$this->get('security.token_storage')->getToken()->getUser();

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
                $this->get('session')->getFlashBag()->add('error', 'Désolé un problème est survenu.');

            }
        }

        return $this->render('association/contact.html.twig', array(
            // on renvoi dans la vue "la vue" du formulaire
            'formContact' => $formContact->createView(),
            'user'=>$user,
        ));
    }

    /**
     * Generates a inscription form.
     *
     * @Route("/association/inscription", name="association_inscription")
     * @Method({"GET","POST"})
     */
    public function demandeAction(Request $r)
    {

        $user=$this->get('security.token_storage')->getToken()->getUser();

        // on créer le formulaire à partir de notre formType
        $formDemande = $this->createForm(new DemandeType());

        // on vérifie si c'est une méthode post
        if($r->isMethod('post')){
            // on récupére les informations du formulaire soumis et on set les différents champs de notre formulaile avec, donc la class Contact.
            $formDemande->handleRequest($r);

            //on vérifi si le formulaire est valide, souvenez vous des différents validateurs que nous avons mis en place sur notre entitée contact
            if($formDemande->isValid()){

                // Ici on récupére la class Demande qui a été préalablement Set avec les champs du formulaire
                $demande = $formDemande->getData();

                //On envoie le message à l'admin pour le prevenir d'une demande
                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande d\'inscription')
                    ->setFrom($demande->getEmail())
                    // notre adresse mail
                    ->setTo('guillossou.michele@gmail.com')
                    //->setContentType('text/html')
                    //ici nous allons utiliser un template pour pouvoir styliser notre mail si nous le souhaitons
                    ->setBody(
                        $this->renderView('association/demandeMailAdmin.html.twig', array(
                                'demande' => $demande
                            )
                        ), 'text/html'
                    )
                ;

                //On envoie le message à la personne qui fait la demamnde
                $message2 = \Swift_Message::newInstance()
                    ->setSubject('Demande d\'inscription')
                    ->setFrom('guillossou.michele@gmail.com')
                    // notre adresse mail
                    ->setTo($demande->getEmail())
                    //->setContentType('text/html')
                    //ici nous allons utiliser un template pour pouvoir styliser notre mail si nous le souhaitons
                    ->setBody(
                        $this->renderView('association/demandeMail.html.twig', array(
                                'demande' => $demande
                            )
                        ), 'text/html'
                    )
                ;

                // nous appelons le service swiftmailer et on envoi :)
                $this->get('mailer')->send($message);
                $this->get('mailer')->send($message2);

                // on retourne une message flash pour l'utilisateur pour le prévenir que son mail est bien parti
                $this->get('session')->getFlashBag()->add('success', 'Votre demande d\'inscription a bien été prise en compte ! Vous serez contacté prochainement.');
            }else{
                //si le formulaire n'est pas valide en plus des erreurs du form
                $this->get('session')->getFlashBag()->add('error', 'Désolé un problème est survenu.');

            }
        }

        return $this->render('association/demandeForm.html.twig', array(
            // on renvoi dans la vue "la vue" du formulaire
            'formContact' => $formDemande->createView(),
            'user'=>$user,
        ));
    }
}
