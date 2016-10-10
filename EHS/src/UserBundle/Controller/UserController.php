<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * User controller.
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new User entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        
        $form = $this->createForm('UserBundle\Form\UserType', $user);
        $form->remove('password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $em = $this->getDoctrine()->getManager();
            
            $plainPassword = $user->generateStrongPassword(25);
            //var_dump($plainPassword);die();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $plainPassword);

            $user->setPassword($encoded);
            $em->persist($user);
            $em->flush();
            $mail=$this->getParameter('mailer_user');

            // A decommenter lors de l'implémentation
            //pour envoyer un mail a l'inscription
            $message = \Swift_Message::newInstance()
                ->setSubject('Bienvenue')
                ->setFrom($mail)
                // notre adresse mail
                ->setTo($data->getEmail())
                //->setContentType('text/html')
                //ici nous allons utiliser un template pour pouvoir styliser notre mail si nous le souhaitons
                ->setBody(
                    $this->renderView('association/newUser.html.twig', array(
                            'user' => $user,
                            'password'=>$plainPassword
                        )
                    ), 'text/html'
                )

            ;
            $this->get('mailer')->send($message);

            $this->addFlash('success',
                'Utilisateur ajouté !');

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a User entity in public mode.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}/profile", name="user_showpublic")
     * @Method("GET")
     */
    public function showPublicAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.public.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing User entity, as his own profile.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UserBundle\Form\UserType', $user);
        $editForm->remove('userRoles');
        $editForm->remove('password');
        $editForm->remove('username');
        $editForm->handleRequest($request);
        //var_dump($editForm);die();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success',
                'Profil mis à jour !');

            return $this->redirectToRoute('index');
        }
        //On verifie que l'utilisateur cherche bien à éditer son propre profil
        if($this->get('security.token_storage')->getToken()->getUser()->getUsername()
        == $editForm->getData()->getUsername())
        {
            return $this->render('user/user.edit.html.twig', array(
                'user' => $user,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }
        //sinon on renvoie une erreur 403
        else{
            throw new AccessDeniedException();
        }

    }

    /**
     * Displays a form to edit an existing User entity as Admin editing.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/editadmin", name="user_editadmin")
     * @Method({"GET", "POST"})
     */
    public function editAdminAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UserBundle\Form\UserType', $user);

        $editForm->remove('password');
        $editForm->add('password','text',array('label'=>'(Si vous voulez changer le mot de passe, écrivez en un nouveau.
         Sinon, ne touchez rien !)'));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data=$editForm->getData();
            if(strlen(utf8_decode($data->getPassword()))<20)
            {
                $plainPassword = $data->getPassword();
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $plainPassword);

                $user->setPassword($encoded);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success',
                'Utilisateur mis à jour !');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository('UserBundle:User');
        //custom repo method for finding users with ROLE_ADMIN
        $admins=$repo->findAdmins();

        if($user->getRoles()[0]->getRole() != 'ROLE_ADMIN')
        {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
            }

            $this->addFlash('success',
                'Utilisateur '.$user->getUsername().' supprimé !');

        }else if ($user->getRoles()[0]->getRole() == 'ROLE_ADMIN'
        AND count($admins)==1){

            $this->get('session')->getFlashBag()->set('error',
                'Attention, ne supprimez pas le dernier compte Administrateur !');

        }
        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a User entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
