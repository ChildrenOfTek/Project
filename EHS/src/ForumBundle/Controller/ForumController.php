<?php

namespace ForumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ForumBundle\Entity\Forum;
use ForumBundle\Form\ForumType;


/**
 * Forum controller.
 *
 * @Route("/forum")
 */
class ForumController extends Controller
{
    /**
     * Lists all Forum entities.
     *
     * @Route("/", name="forum_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $forums = $em->getRepository('ForumBundle:Forum')->findAll();

        return $this->render('forum/index.html.twig', array(
            'forums' => $forums,
        ));
    }

    /**
     * Creates a new Forum entity.
     *
     * @Route("/new", name="forum_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $forum = new Forum();
        $form = $this->createForm('ForumBundle\Form\ForumType', $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();

            return $this->redirectToRoute('forum_show', array('id' => $forum->getId()));
        }

        return $this->render('forum/new.html.twig', array(
            'forum' => $forum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Forum entity.
     *
     * @Route("/{id}", name="forum_show")
     * @Method("GET")
     */
    public function showAction(Forum $forum)
    {
        $deleteForm = $this->createDeleteForm($forum);

        return $this->render('forum/show.html.twig', array(
            'forum' => $forum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Forum entity.
     *
     * @Route("/{id}/edit", name="forum_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Forum $forum)
    {
        $deleteForm = $this->createDeleteForm($forum);
        $editForm = $this->createForm('ForumBundle\Form\ForumType', $forum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();

            return $this->redirectToRoute('forum_edit', array('id' => $forum->getId()));
        }

        return $this->render('forum/edit.html.twig', array(
            'forum' => $forum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Forum entity.
     *
     * @Route("/{id}", name="forum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Forum $forum)
    {
        $form = $this->createDeleteForm($forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($forum);
            $em->flush();
        }

        return $this->redirectToRoute('forum_index');
    }

    /**
     * Creates a form to delete a Forum entity.
     *
     * @param Forum $forum The Forum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Forum $forum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forum_delete', array('id' => $forum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
