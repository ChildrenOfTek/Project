<?php

namespace EventsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EventsBundle\Entity\Registration;
use EventsBundle\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Registration controller.
 *
 * @Route("/registration")
 */
class RegistrationController extends Controller
{
    /**
     * Lists all Registration entities.
     *
     * @Route("/", name="registration_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $registrations = $em->getRepository('EventsBundle:Registration')->findAll();

        return $this->render('registration/index.html.twig', array(
            'registrations' => $registrations,
        ));
    }

    /**
     * Creates a new Registration entity.
     *
     * @Route("/{id}/new", name="registration_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $registration = new Registration();
        $form = $this->createForm('EventsBundle\Form\RegistrationType', $registration);            
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

            $repoE= $em->getRepository('EventsBundle:Events');
            $eventE=$repoE->findOneBy(array('id'=> $id));

            $repoR= $em->getRepository('EventsBundle:Registration');
            $eventR=$repoR->findRegistration($id);

        if(count($eventR) >= $eventE->getPlaces())
            {
                $this->addFlash('error',
                'Il n\'y a plus de place disponible pour cet évènement  !');
                return $this->redirectToRoute('events_index');                
            }else{

        if ($form->isSubmitted() && $form->isValid()) {            
            

                $registration->setEvents($eventE);
                $em->persist($registration);
                $em->flush();
                $this->addFlash('success',
                'Votre inscription a bien été prise en compte !');

                return $this->redirectToRoute('events_show', array('id' => $registration->getEvents()->getId()));
                
            } 
        }

        return $this->render('registration/new.html.twig', array(
            'registration' => $registration,
            'form' => $form->createView(),
            'event' => $eventE
        ));
    }

    /**
     * Finds and displays a Registration entity.
     *
     * @Route("/{id}", name="registration_show")
     * @Method("GET")
     */
    public function showAction(Registration $registration)
    {
        $deleteForm = $this->createDeleteForm($registration);

        return $this->render('registration/show.html.twig', array(
            'registration' => $registration,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Registration entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="registration_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Registration $registration)
    {
        $deleteForm = $this->createDeleteForm($registration);
        $editForm = $this->createForm('EventsBundle\Form\RegistrationType', $registration);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registration);
            $em->flush();

            return $this->redirectToRoute('registration_edit', array('id' => $registration->getId()));
        }

        return $this->render('registration/edit.html.twig', array(
            'registration' => $registration,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Registration entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="registration_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Registration $registration)
    {
        $form = $this->createDeleteForm($registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($registration);
            $em->flush();
        }

        return $this->redirectToRoute('registration_index');
    }

    /**
     * Creates a form to delete a Registration entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @param Registration $registration The Registration entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Registration $registration)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registration_delete', array('id' => $registration->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
