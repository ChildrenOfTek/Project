<?php

namespace CalendarBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CalendarBundle\Entity\Calendar;

/**
 * Calendar controller.
 *
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * Lists all Calendar entities.
     *
     * @Route("/", name="agenda_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $calendars = $em->getRepository('CalendarBundle:Calendar')->findAll();

        return $this->render('calendar/index.html.twig', array(
            'calendars' => $calendars,
        ));
    }

    /**
     * Finds and displays a Calendar entity.
     *
     * @Route("/{id}", name="agenda_show")
     * @Method("GET")
     */
    public function showAction(Calendar $calendar)
    {

        return $this->render('calendar/show.html.twig', array(
            'calendar' => $calendar,
        ));
    }
}
