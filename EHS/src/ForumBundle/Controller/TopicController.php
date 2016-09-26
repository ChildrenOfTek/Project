<?php

namespace ForumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ForumBundle\Entity\Topic;
use ForumBundle\Form\TopicType;

/**
 * Topic controller.
 *
 * @Route("/topic")
 */
class TopicController extends Controller
{
    /**
     * Lists all Topic entities.
     *
     * @Route("/", name="topic_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $topics = $em->getRepository('ForumBundle:Topic')->findAll();

        return $this->render('topic/index.html.twig', array(
            'topics' => $topics,
        ));
    }

    /**
     * Creates a new Topic entity.
     *
     * @Route("/new", name="topic_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $topic = new Topic();
        $form = $this->createForm('ForumBundle\Form\TopicType', $topic);
        $form->handleRequest($request);
        $id=$_GET['id'];
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $forum=$em->getRepository('ForumBundle:Forum')->find($id);
            $topic->setForum($forum);
            $topic->setDateCreated(new \DateTime());
            $em->persist($topic);
            $em->flush();
            
            return $this->redirectToRoute('forum_show', array('id' => $_GET['id']));
        }

        return $this->render('topic/new.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Topic entity.
     *
     * @Route("/{id}", name="topic_show")
     * @Method("GET")
     */
    public function showAction(Topic $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);
        
        //var_dump($this->getUser()->getUsername());
        return $this->render('topic/show.html.twig', array(
            'topic' => $topic,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Topic entity.
     *
     * @Route("/{id}/edit", name="topic_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Topic $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);
        $editForm = $this->createForm('ForumBundle\Form\TopicType', $topic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('topic_edit', array('id' => $topic->getId()));
        }

        return $this->render('topic/edit.html.twig', array(
            'topic' => $topic,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Topic entity.
     *
     * @Route("/{id}", name="topic_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Topic $topic)
    {
        $form = $this->createDeleteForm($topic);
        $form->handleRequest($request);
        $id= $topic->getForum()->getId();
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($topic);
            $em->flush();
            
        }
        ;
        
        return $this->redirectToRoute('forum_show', array('id' => $id));
        
    }

    /**
     * Creates a form to delete a Topic entity.
     *
     * @param Topic $topic The Topic entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Topic $topic)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('topic_delete', array('id' => $topic->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
