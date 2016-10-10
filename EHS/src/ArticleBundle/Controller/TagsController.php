<?php

namespace ArticleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ArticleBundle\Entity\Tags;
use ArticleBundle\Form\TagsType;

/**
 * Tags controller.
 *
 * @Route("/tags")
 */
class TagsController extends Controller
{
    /**
     * Lists all Tags entities.
     *
     * @Route("/", name="tags_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('ArticleBundle:Tags')->findAll();

        return $this->render('tags/index.html.twig', array(
            'tags' => $tags,
        ));
    }

    /**
     * Gives a view with articles matching clicked tag.
     *
     * @Route("/{libelle}/search", name="tags_search")
     * @Method("GET")
     */
    public function tagMatchAction($libelle)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('ArticleBundle:Tags')->findOneBy(array('libelle'=>$libelle));

        $query = $em->createQuery('
                                    SELECT a
                                    FROM ArticleBundle:Article a
                                    JOIN a.tag t
                                    WHERE t.libelle = :libelle
                                ');

        $query->setParameter('libelle', $libelle);

        $articles= $query->getResult();
        //var_dump($query->getResult());die();

        return $this->render('tags/search.html.twig', array(
            'tags' => $tags,
            'articles'=>$articles
        ));
    }

    /**
     * Gives a view with events matching clicked tag.
     *
     * @Route("/{libelle}/events/search", name="tags_events_search")
     * @Method("GET")
     */
    public function tagEventsMatchAction($libelle)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('ArticleBundle:Tags')->findOneBy(array('libelle'=>$libelle));

        $query1 = $em->createQuery('
                                    SELECT e
                                    FROM EventsBundle:Events e
                                    JOIN e.tag t
                                    WHERE t.libelle = :libelle
                                    AND e.end < :now
                                    ORDER BY e.start DESC
                                ');
        $query2 = $em->createQuery('
                                    SELECT e
                                    FROM EventsBundle:Events e
                                    JOIN e.tag t
                                    WHERE t.libelle = :libelle
                                    AND e.end >= :now
                                    ORDER BY e.start ASC
                                ');

        $query1->setParameter('libelle', $libelle);
        $query1->setParameter('now', new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME);
        $query2->setParameter('libelle', $libelle);
        $query2->setParameter('now', new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME);

        $pastevents= $query1->getResult();
        $futureevents= $query2->getResult();
        //var_dump($query->getResult());die();

        return $this->render('tags/search.html.twig', array(
            'tags' => $tags,
            'pastevents' => $pastevents,
            'futureevents' => $futureevents
        ));
    }

    /**
     * Creates a new Tags entity.
     *
     * @Route("/new", name="tags_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tag = new Tags();
        $form = $this->createForm('ArticleBundle\Form\TagsType', $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('tags_show', array('id' => $tag->getId()));
        }

        return $this->render('tags/new.html.twig', array(
            'tag' => $tag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tags entity.
     *
     * @Route("/{id}", name="tags_show")
     * @Method("GET")
     */
    public function showAction(Tags $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);

        return $this->render('tags/show.html.twig', array(
            'tag' => $tag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tags entity.
     *
     * @Route("/{id}/edit", name="tags_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tags $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createForm('ArticleBundle\Form\TagsType', $tag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('tags_edit', array('id' => $tag->getId()));
        }

        return $this->render('tags/edit.html.twig', array(
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tags entity.
     *
     * @Route("/{id}", name="tags_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tags $tag)
    {
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();
        }

        return $this->redirectToRoute('tags_index');
    }

    /**
     * Creates a form to delete a Tags entity.
     *
     * @param Tags $tag The Tags entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tags $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tags_delete', array('id' => $tag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
