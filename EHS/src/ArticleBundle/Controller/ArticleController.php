<?php

namespace ArticleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ArticleBundle\Entity\Article;
use ArticleBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Article controller.
 *
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     * @Route("/", name="article_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ArticleBundle:Article')->findAll();

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Lists all Article entities to be published.
     *
     * @Route("/publish", name="article_publish")
     * @Method("GET")
     */
    public function indexPublishAction()
    {
        $em = $this->getDoctrine()->getManager();
        $date=new \DateTime('now');
        $query = $em->createQuery(
            'SELECT a
                FROM ArticleBundle:Article a
                WHERE a.datePublication <= :date and a.online = 1
                ORDER BY a.dateArticle ASC'
        )->setParameter('date', $date);

        $articles = $query->getResult();

        return $this->render('article/all.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * Creates a new Article entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/new", name="article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em=$this->getDoctrine()->getEntityManager();
        $article = new Article();
        //On passe l'entity manager au formulaire
        $form = $this->createForm(new ArticleType($em),$article );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $date=new \DateTime('now');

            $article->setUser($data->getUser()->getUsername());
            $article->setDateArticle($date);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Article entity.
     * @Route("/{id}", name="article_show")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Article entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('ArticleBundle\Form\ArticleTypeEdit', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $data=$editForm->getData();

            $article->setUser($data->getUser()->getUsername());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_edit', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Article entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a Article entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @param Article $article The Article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
