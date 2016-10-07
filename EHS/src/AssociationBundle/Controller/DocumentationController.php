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

/**
 * Documentation controller.
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/documentation")
 */
class DocumentationController extends Controller
{
    /**
     * Lists all documentations availables.
     * @Route("/", name="association_archivedocumentation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $archives = $em->getRepository('AssociationBundle:Archive')->findAll();

        return $this->render('documentation/index.html.twig', array(

        ));
    }

    /**
     * Finds and displays a documentation.
     *
     * @Route("/{doc}", name="documentation_show")
     * @Method("GET")
     */
    public function showAction($doc)
    {
        return $this->render('documentation/'.$doc.'.html.twig', array(
        ));
    }
}