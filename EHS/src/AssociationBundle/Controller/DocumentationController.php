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
 *
 * @Route("/documentation")
 */
class DocumentationController extends Controller
{

    /**
     * Finds and displays a documentation.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{doc}", name="documentation_show")
     * @Method("GET")
     */
    public function showAction($doc)
    {
        return $this->render('documentation/'.$doc.'.html.twig', array(
        ));
    }

    /**
     * Finds and displays a documentation.
     * @Security("has_role('ROLE_PRESS')")
     * @Route("/{doc}/press", name="documentation_show_press")
     * @Method("GET")
     */
    public function showPressAction($doc)
    {
        return $this->render('documentation/'.$doc.'.press.html.twig', array(
        ));
    }
}