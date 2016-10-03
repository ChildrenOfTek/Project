<?php

namespace AssociationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AssociationBundle\Entity\Archive;
use AssociationBundle\Form\ArchiveType;

/**
 * Archive controller.
 *
 * @Route("/association/archive")
 */
class ArchiveController extends Controller
{
    /**
     * Lists all Archive entities.
     *
     * @Route("/", name="association_archive_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $archives = $em->getRepository('AssociationBundle:Archive')->findAll();

        return $this->render('archive/index.html.twig', array(
            'archives' => $archives,
        ));
    }

    /**
     * Creates a new Archive entity.
     *
     * @Route("/new", name="association_archive_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $archive = new Archive();
        $form = $this->createForm('AssociationBundle\Form\ArchiveType', $archive);
        $form->remove('dateCreation');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $date= new \DateTime();
            $archive->setDateCreation($date);
            $em->persist($archive);
            $em->flush();

            $this->addFlash('success',
                'L\'archive a bien été crée !');

            return $this->redirectToRoute('association_archive_show', array('id' => $archive->getId()));
        }

        return $this->render('archive/new.html.twig', array(
            'archive' => $archive,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Archive entity.
     *
     * @Route("/{id}", name="association_archive_show")
     * @Method("GET")
     */
    public function showAction(Archive $archive)
    {
        $deleteForm = $this->createDeleteForm($archive);

        return $this->render('archive/show.html.twig', array(
            'archive' => $archive,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Archive entity.
     *
     * @Route("/{id}/edit", name="association_archive_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Archive $archive)
    {
        $deleteForm = $this->createDeleteForm($archive);
        $editForm = $this->createForm('AssociationBundle\Form\ArchiveType', $archive);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($archive);
            $em->flush();

            $this->addFlash('success',
                'L\'archive a bien été mise à jour !');

            return $this->redirectToRoute('association_archive_edit', array('id' => $archive->getId()));
        }

        return $this->render('archive/edit.html.twig', array(
            'archive' => $archive,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Archive entity.
     *
     * @Route("/{id}", name="association_archive_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Archive $archive)
    {
        $form = $this->createDeleteForm($archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($archive);
            $em->flush();
        }

        $this->addFlash('success',
            'L\'archive a bien été supprimée !');

        return $this->redirectToRoute('association_archive_index');
    }

    /**
     * Creates a form to delete a Archive entity.
     *
     * @param Archive $archive The Archive entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Archive $archive)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('association_archive_delete', array('id' => $archive->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
