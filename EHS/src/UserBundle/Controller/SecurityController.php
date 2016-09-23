<?php

namespace UserBundle\Controller;

/**
 * Description of SecurityController
 *
 *
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render(
        'security/login.html.twig',
        array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        )
    );
    }
    /**
     * @Route("/logout")
     */
    public function logoutAction()
    {
        return $this->render('association/index.html.twig');
    }

    //envoyer un mail sur une route reset avec l'id du mail

}
