<?php

namespace AssociationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AssociationBundle\Form\ContactType;
use AssociationBundle\Form\DemandeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Finder\Finder;


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

    /* A SUIVRE ACTIONS PLUS SPECIFIQUES COMME FORMULAIRE DE CONTACT, DEMANDE D'INSCRIPTION,... */

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
                    ->setTo($this->getParameter('mailer_user'))
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
                return $this->redirectToRoute('index');
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

            //on vérifie si le formulaire est valide, souvenez vous des différents validateurs que nous avons mis en place sur notre entitée contact
            if($formDemande->isValid()){
                //on verifie si cet email est deja existant en base
                $data=$formDemande->getData();
                $exist=$this->getDoctrine()
                    ->getManager()
                    ->getRepository('UserBundle:User')
                    ->findOneBy(array('email'=>$data->getEmail()));
                //si oui on redirige avec une erreur
                if($exist)
                {
                    $this->get('session')->getFlashBag()->add('error', 'Cet email est déjà pris !');
                    return $this->render('association/demandeForm.html.twig', array(
                        // on renvoi dans la vue "la vue" du formulaire
                        'formContact' => $formDemande->createView(),
                        'user'=>$user,
                    ));
                }

                // Ici on récupére la class Demande qui a été préalablement Set avec les champs du formulaire
                $demande = $formDemande->getData();

                //On envoie le message à l'admin pour le prevenir d'une demande
                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande d\'inscription')
                    ->setFrom($demande->getEmail())
                    // notre adresse mail
                    ->setTo($this->getParameter('mailer_user'))
                    //->setContentType('text/html')
                    //ici nous allons utiliser un template pour pouvoir styliser notre mail si nous le souhaitons
                    ->setBody(
                        $this->renderView('association/demandeMailAdmin.html.twig', array(
                                'demande' => $demande
                            )
                        ), 'text/html'
                    )
                ;

                //On envoie le message à la personne qui fait la demande
                $message2 = \Swift_Message::newInstance()
                    ->setSubject('Demande d\'inscription')
                    ->setFrom($this->getParameter('mailer_user'))
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
                return $this->redirectToRoute('index');
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

    /**
     * Generates a phone book.
     * @Security("has_role('ROLE_PRESS')")
     * @Route("/association/annuaire", name="association_annuaire")
     */
    public function annuaireAction()
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository('UserBundle:User');
        $annuaire=$repo->findAnnuaire();

        return $this->render('press/annuaire.html.twig', array(
            'annuaire' => $annuaire,
        ));

    }

    /**
     * Finds and displays a User entity in phone book mode.
     * @Security("has_role('ROLE_PRESS')")
     * @Route("/association/presse/{id}/profile", name="association_annuaire_profile")
     * @Method("GET")
     */
    public function showPressAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository('UserBundle:User');
        $user=$repo->findOneBy(array('id'=>$id));

        return $this->render('press/press.profile.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Generates a contact form for Press.
     * @Security("has_role('ROLE_PRESS')")
     * @Route("/association/presse/{id}/contact", name="contact_presse")
     * @Method({"GET","POST"})
     */
    public function contactPresseAction(Request $r,$id)
    {
        $user=$this->get('security.token_storage')->getToken()->getUser();
        $formContact = $this->createForm(new ContactType());
        $formContact->remove('email');
        $formContact->add('email',EmailType::class,array(
            'data'=>$user->getEmail(),
            'label'=>'Votre email pour la réponse: '));

        $em=$this->getDoctrine()->getManager();
        $destinataire=$em->getRepository('UserBundle:User')
            ->findOneBy(array('id'=>$id));

        //on verifie que user != destinataire
        if($user->getId() == $destinataire->getId())
        {
            $this->get('session')->getFlashBag()->add('error', 'Désolé, vous etes le destinateur et le destinataire.');
            return $this->redirectToRoute('association_annuaire');
        }

        if($r->isMethod('post')){
            $formContact->handleRequest($r);

            if($formContact->isValid()){
                $contact = $formContact->getData();

                $message = \Swift_Message::newInstance()
                    ->setSubject($contact->getSujet())
                    ->setFrom($contact->getEmail())
                    ->setTo($destinataire->getEmail())
                    ->setBody(
                        $this->renderView('press/contactPress.mail.html.twig', array(
                                'contact' => $contact,
                                'user' => $user
                            )
                        ), 'text/html'
                    )
                ;

                $this->get('mailer')->send($message);

                // on retourne une message flash pour l'utilisateur pour le prévenir que son mail est bien parti
                $this->get('session')->getFlashBag()->add('success', 'Votre email a bien été envoyé a '.$destinataire->getEmail());
                return $this->redirectToRoute('association_annuaire');
            }else{
                //si le formulaire n'est pas valide en plus des erreurs du form
                $this->get('session')->getFlashBag()->add('error', 'Désolé un problème est survenu.');
                return $this->redirectToRoute('contact_presse', array('id' => $destinataire->getId()));
            }
        }

        return $this->render('press/contactPress.html.twig', array(
            // on renvoie dans la vue "la vue" du formulaire
            'formContact' => $formContact->createView(),
            'user'=>$user,
            'destinataire'=>$destinataire
        ));
    }

    /**
     * Lists all images in the web folder.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/finder", name="association_archive_finder")
     * @Method("GET")
     */
    public function finderAction()
    {
        $sort = function (\SplFileInfo $a, \SplFileInfo $b)
        {
            return strcmp($b->getCTime(), $a->getCTime());
        };

        $finder = new Finder();
        $finder2=new Finder();
        //ce finder reccupere les fichiers
        $finder->files()->in($this->get('kernel'
            )->getRootDir() . '/../web/public/img/article')->sort($sort);
        //ce finder reccupere les dossiers
        $finder2->directories()->in($this->get('kernel'
            )->getRootDir() . '/../web/public/img/article')->sort($sort);
        $files=[];
        $dirs=[];
        //on crée deux tableaux pour chacunes des entrées
        foreach ($finder as $file) {
            $files[]=$file;
        }
        foreach ($finder2 as $dir) {
            $dirs[]=$dir;
        }
        return $this->render('association/finder.html.twig', array(
            // on renvoie dans la vue "la vue" du formulaire
            'files'=>$files,
            'dirs'=>$dirs
        ));
    }

    /**
     * Deletes an image corresponding to an article.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/finder/{name}/{dir}/delete", name="association_archive_finder_delete")
     * @Method("GET")
     */
    public function finderDeleteAction($name,$dir)
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository('ArticleBundle:Article');
        $article=$repo->findOneBy(array('imageName'=>$name));
        //on verifie que l'article existe, sinon on lance une erreur
        if($article){
            $file=$this->get('kernel'
                )->getRootDir() . '/../web/public/img/article/'.$dir.'/'.$name;
            //on verifie que le fichier existe, sinon on lance une erreur
            if($file){
                unlink($file);
                //var_dump($article);die();
                $article->setImageName('');
                $em->persist($article);
                $em->flush();
                $this->addFlash('success','L\'image a bien été supprimée !');
            }else{
                $this->addFlash('error','L\'image n\'a pas été trouvée !');
                return $this->finderAction();
            }

            return $this->finderAction();

        }else{
            $this->addFlash('error','L\'article n\'existe pas !');
            return $this->finderAction();

        }


    }
}
