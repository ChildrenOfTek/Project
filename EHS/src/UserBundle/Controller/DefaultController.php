<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }

    /**
     * Generates a contact form.
     *
     * @Route("/contact", name="contact")
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $request)
    {
        $user= $this->get('security.context')->getToken()->getUser();
        return $this->render('user/contact.html.twig', array(
            'user' => $user,

        ));
    }

    /**
     * Generates an about us page.
     *
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('UserBundle:Default:about.html.twig');
    }



}
