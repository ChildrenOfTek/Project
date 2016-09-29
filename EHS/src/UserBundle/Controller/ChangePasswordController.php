<?php
namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\ChangePasswordType;
use UserBundle\Form\Model\ChangePassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;

class ChangePasswordController extends Controller
{

    /**
     * Generates a form for password changing
     *
     * @Route("/password_change", name="password_change")
     *
     */
    public function changePasswdAction(Request $request)
    {

    $changePasswordModel = new ChangePassword();
    $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
    // perform some action,
    // such as encoding with MessageDigestPasswordEncoder and persist
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $data=$form->getData();

        $em = $this->getDoctrine()->getManager();

        $plainPassword = $data->getNewPassword();

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);
        $em->persist($user);
        $em->flush();

    return $this->redirectToRoute('index');
    }

    return $this->render('security/changePassword.html.twig', array(
    'form' => $form->createView(),
));
}
}