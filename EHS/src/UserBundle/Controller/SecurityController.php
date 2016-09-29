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
        $this->addFlash('notice','Merci de vous enregister !');
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
    /**
     * Generates another random password.
     * @Route("/forgot_password", name="forgot_password")
     * @Method({"GET", "POST"})
     */
    public function newForgotPassword(Request $request)
    {
        $form=$this->createForm('UserBundle\Form\ResetType');
        $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository('UserBundle:User');

        if ($form->isSubmitted() && $form->isValid())
        {
            $data=$form->getData();
            $user=$repo->findOneByEmail($data->getEmail());
            //var_dump($data);var_dump($user);die();
            if($user != null)
            {
                $password=$user->generateStrongPassword(25);
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $password);

                $user->setPassword($encoded);
                $em->persist($user);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande de nouveau mot de passe')
                    ->setFrom('guillossou.michele@gmail.com')
                    // notre adresse mail
                    ->setTo($user->getEmail())
                    //->setContentType('text/html')
                    //ici nous allons utiliser un template pour pouvoir styliser notre mail si nous le souhaitons
                    ->setBody(
                        $this->renderView('association/forgot.html.twig', array(
                                'user' => $user,
                                'password'=>$password
                            )
                        ), 'text/html'
                    )

                ;
                $this->get('mailer')->send($message);
                //flashbag
                $this->get('session')->getFlashBag()->set('success',
                    'Votre demande à bien été prise en compte !');

                return $this->redirectToRoute('index');
            }
            else{
                //flashbag
                $this->get('session')->getFlashBag()->set('error',
                    'Aucun email ne correspond');
                return $this->redirectToRoute('login');
            }


        }
        return $this->render('security/forgot.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}
