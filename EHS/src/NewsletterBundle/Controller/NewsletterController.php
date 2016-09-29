<?php

namespace NewsletterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use NewsletterBundle\Entity\Newsletter;
use NewsletterBundle\Form\NewsletterType;
use UserBundle\Entity\User;

/**
 * Newsletter controller.
 *
 * @Route("/newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * Lists all Newsletter entities.
     *
     * @Route("/", name="newsletter_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $newsletters = $em->getRepository('NewsletterBundle:Newsletter')->findAll();
        return $this->render('NewsletterBundle:Default:index.html.twig', array(
            'newsletters' => $newsletters,
        ));
    }

     /**
     * Creates a new Newsletter entity.
     *
     * @Route("/new", name="newsletter_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $newsletter = new Newsletter();
        $form = $this->createForm('NewsletterBundle\Form\NewsletterType', $newsletter);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('ArticleBundle:Article')->findNewArticles();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            return $this->redirectToRoute('newsletter_show', array('id' => $newsletter->getId()));
        };

        return $this->render('NewsletterBundle:Default:new.html.twig', array(
            'newsletter' => $newsletter,
            'articles' => $articles,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Newsletter entity.
     *
     * @Route("/{id}", name="newsletter_show")
     * @Method("GET")
     */
    public function showAction(Newsletter $newsletter)
    {
        $deleteForm = $this->createDeleteForm($newsletter);

        return $this->render('NewsletterBundle:Default:show.html.twig', array(
            'newsletter' => $newsletter,
        ));
    }

    /**
     * Displays a form to edit an existing Newsletter entity.
     *
     * @Route("/edit/{id}", name="newsletter_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Newsletter $newsletter)
    {
        $deleteForm = $this->createDeleteForm($newsletter);
        $editForm = $this->createForm('NewsletterBundle\Form\NewsletterType', $newsletter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            return $this->redirectToRoute('newsletter_index');
        }

        return $this->render('NewsletterBundle:Default:edit.html.twig', array(
            'newsletter' => $newsletter,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Newsletter entity.
     *
     * @Route("/delete/{id}", name="newsletter_delete")
     * @Method("GET")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('NewsletterBundle:Newsletter');
        $newsletter = $repo->find($id);
        $em->remove($newsletter);
        $em->flush();

        return $this->redirectToRoute('newsletter_index');
    }

    /**
     * Creates a form to delete a Newsletter entity.
     *
     * @param Newsletter $newsletter The Newsletter entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Newsletter $newsletter)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newsletter_delete', array('id' => $newsletter->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a Newsletter entity.
     *
     * @Route("/send/{id}", name="newsletter_send")
     * @Method("GET")
     */
    public function sendAction(Newsletter $newsletter) {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $checked = [];

        foreach ($users as $user) {
            $message = \Swift_Message::newInstance()
                ->setSubject($newsletter->getSujet())
                ->setFrom(array('guillossou.michele@gmail.com' => 'Michele Guillossou'))
                ->setTo(array($user->getEmail() => $user->getPrenom() . " " . $user->getNom()))
                ->setBody($newsletter->getTexte(), 'text/html');
            $this->get('mailer')->send($message);
            $checked[] = $user->getPrenom() . " " . $user->getNom();
        }
         return $this->render('NewsletterBundle:Default:send.html.twig', array(
            'checked' => $checked,
        ));

    }

}
