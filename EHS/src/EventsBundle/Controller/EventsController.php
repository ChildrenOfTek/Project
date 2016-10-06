<?php

namespace EventsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EventsBundle\Entity\Events;
use EventsBundle\Form\EventsType;
use EventsBundle\Form\EventsTypeEdit;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Events controller.
 *
 * @Route("/events")
 */
class EventsController extends Controller
{
    /**
     * Lists all Events entities.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="events_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EventsBundle:Events')->findBy(array(), array('start' => 'ASC'))
        ;

        return $this->render('events/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new Events entity.
     *
     * @Route("/new", name="events_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    	$em=$this->getDoctrine()->getEntityManager();    	
        $event = new Events();
        // $form = $this->createForm('EventsBundle\Form\EventsType', $event);
        $form = $this->createForm(new EventsType($em), $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('events_show', array('id' => $event->getId()));
        }

        return $this->render('events/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Events entity.
     *
     * @Route("/{id}", name="events_show")
     * @Method("GET")
     */
    public function showAction(Events $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('events/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Events entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="events_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Events $event)
    {
        $em=$this->getDoctrine()->getEntityManager();

        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm(new EventsTypeEdit($em), $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash('success',
                'L\'évènement a bien été mis à jour !');

            return $this->redirectToRoute('events_edit', array('id' => $event->getId()));
        }

        return $this->render('events/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Events entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="events_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Events $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('events_index');
    }

    /**
     * Creates a form to delete a Events entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @param Events $event The Events entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Events $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('events_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
