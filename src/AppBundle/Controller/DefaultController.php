<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Voryx\ThruwayBundle\Annotation\Register;
use Voryx\ThruwayBundle\Annotation\Worker;

use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Worker("line", maxProcesses="5")
 *
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Person');
        dump($repo->findAll());
        return $this->render(":default:index.html.twig");
    }
    /**
     * @Route("/clerk", name="clerk")
     */
    public function Action(Request $request)
    {
        return $this->render(":default:clerk.html.twig");
    }

    /**
     * @Route("/number", name="number")
     */
    public function numberAction(Request $request)
    {
        return $this->render(":default:number.html.twig");
    }

    /**
     *
     * @Register("get_in_line")
     *
     */
    public function getInLine()
    {
        $details    = $this->get('thruway.details');
        $personRepo = $this->getDoctrine()->getRepository('AppBundle:Person');
        $person     = $personRepo->findOneBy(["session" => $details->getDetails()->caller]);

        if (!$person) {
            $person = $personRepo->createPersonFromCallDetails($details);
        }

        return $person->getId();
    }

    /**
     *
     * @Register("next")
     *
     */
    public function next()
    {

        $personRepo = $this->getDoctrine()->getRepository('AppBundle:Person');

        //Get the next person in line
        $person = $personRepo->getNextPerson();

        if (!$person) {
            return;
        }

        $personRepo->servePerson($person);

        // Publish to the topic `line_change`.  The other clients will listen on this topic
        $this->get('thruway.client')->publish('line_change', [$person->getId()]);

        // RPCs can return values
        return $person->getId();

    }


    /**
     *
     * @Register("line_change_handler", topicStateHandlerFor="line_change")
     *
     * @param $sessionId
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function lineChangeHandler($sessionId)
    {
        //Get the current person being called
        $personId = $this->getDoctrine()->getRepository('AppBundle:Person')->getCurrentPersonId();

        if (!$personId) {
            return;
        }

        $options = ["eligible" => $sessionId];
        $this->get('thruway.client')->publish('line_change', [$personId], [], $options);

    }
}
