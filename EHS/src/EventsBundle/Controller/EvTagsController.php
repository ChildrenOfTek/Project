<?php

namespace EventsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EventsBundle\Entity\EvTags;
use EventsBundle\Form\EvTagsType;

/**
 * EvTags controller.
 *
 * @Route("/evtags")
 */
class EvTagsController extends Controller
{
    /**
     * Lists all EvTags entities.
     *
     * @Route("/", name="evtags_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evTags = $em->getRepository('EventsBundle:EvTags')->findAll();

        return $this->render('evtags/index.html.twig', array(
            'evTags' => $evTags,
        ));
    }

    /**
     * Creates a new EvTags entity.
     *
     * @Route("/new", name="evtags_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evTag = new EvTags();
        $form = $this->createForm('EventsBundle\Form\EvTagsType', $evTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evTag);
            $em->flush();

            return $this->redirectToRoute('evtags_show', array('id' => $evTag->getId()));
        }

        return $this->render('evtags/new.html.twig', array(
            'evTag' => $evTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EvTags entity.
     *
     * @Route("/{id}", name="evtags_show")
     * @Method("GET")
     */
    public function showAction(EvTags $evTag)
    {
        $deleteForm = $this->createDeleteForm($evTag);

        return $this->render('evtags/show.html.twig', array(
            'evTag' => $evTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EvTags entity.
     *
     * @Route("/{id}/edit", name="evtags_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EvTags $evTag)
    {
        $deleteForm = $this->createDeleteForm($evTag);
        $editForm = $this->createForm('EventsBundle\Form\EvTagsType', $evTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evTag);
            $em->flush();

            return $this->redirectToRoute('evtags_edit', array('id' => $evTag->getId()));
        }

        return $this->render('evtags/edit.html.twig', array(
            'evTag' => $evTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EvTags entity.
     *
     * @Route("/{id}", name="evtags_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EvTags $evTag)
    {
        $form = $this->createDeleteForm($evTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evTag);
            $em->flush();
        }

        return $this->redirectToRoute('evtags_index');
    }

    /**
     * Creates a form to delete a EvTags entity.
     *
     * @param EvTags $evTag The EvTags entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EvTags $evTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evtags_delete', array('id' => $evTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
