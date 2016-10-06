<?php

namespace EventsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EventsBundle\Entity\Evtags;
use EventsBundle\Form\EvtagsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Evtags controller.
 *
 * @Route("/evtags")
 */
class EvtagsController extends Controller
{
    /**
     * Lists all Evtags entities.
     *
     * @Route("/", name="evtags_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evtags = $em->getRepository('EventsBundle:Evtags')->findAll();

        return $this->render('evtags/index.html.twig', array(
            'evtags' => $evtags,
        ));
    }

    /**
     * Gives a view with events matching clicked tag.
     *
     * @Route("/{libelle}/search", name="evtags_search")
     * @Method("GET")
     */
    public function evtagMatchAction($libelle)
    {
        $em = $this->getDoctrine()->getManager();

        $evtags = $em->getRepository('EventsBundle:Evtags')->findOneBy(array('libelle'=>$libelle));

        $query = $em->createQuery('
                                    SELECT e
                                    FROM EventsBundle:Events e
                                    JOIN e.evtag t
                                    WHERE t.libelle = :libelle
                                ');

        $query->setParameter('libelle', $libelle);

        $events= $query->getResult();
        //var_dump($query->getResult());die();

        return $this->render('evtags/search.html.twig', array(
            'evtags' => $evtags,
            'events'=>$events
        ));
    }

    /**
     * Creates a new Evtags entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/new", name="evtags_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evtag = new Evtags();
        $form = $this->createForm('EventsBundle\Form\EvtagsType', $evtag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evtag);
            $em->flush();

            return $this->redirectToRoute('evtags_show', array('id' => $evtag->getId()));
        }

        return $this->render('evtags/new.html.twig', array(
            'evtag' => $evtag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Evtags entity.
     *
     * @Route("/{id}", name="evtags_show")
     * @Method("GET")
     */
    public function showAction(Evtags $evtag)
    {
        $deleteForm = $this->createDeleteForm($evtag);

        return $this->render('evtags/show.html.twig', array(
            'evtag' => $evtag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Evtags entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="evtags_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Evtags $evtag)
    {
        $deleteForm = $this->createDeleteForm($evtag);
        $editForm = $this->createForm('EventsBundle\Form\EvtagsType', $evtag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evtag);
            $em->flush();

            return $this->redirectToRoute('evtags_edit', array('id' => $evtag->getId()));
        }

        return $this->render('evtags/edit.html.twig', array(
            'evtag' => $evtag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Evtags entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="evtags_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Evtags $evtag)
    {
        $form = $this->createDeleteForm($evtag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evtag);
            $em->flush();
        }

        return $this->redirectToRoute('evtags_index');
    }

    /**
     * Creates a form to delete a Evtags entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @param Evtags $evtag The Evtags entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evtags $evtag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evtags_delete', array('id' => $evtag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
