<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use EventBundle\Entity\Reservationevent;
use EventBundle\EventBundle;
use EventBundle\Form\EventaddType;
use EventBundle\Form\EventupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use EventBundle\Repository\EventRepository;

/**
 * Event controller.
 *
 * @Route("event")
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if($user != null)
        {
            if($user->getRoles()[0] == 'ROLE_ADMIN')
            {
                 $em = $this->getDoctrine()->getManager();

                 $events = $em->getRepository('EventBundle:Event')->findAll();

                $query=$events;
                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                 $paginator = $this->get('knp_paginator');
                 $result=$paginator->paginate(
                $query,
                $request->query->getInt('page',1),
             $request->query->getInt('limit',1)
                );
            return $this->render('@Event/event/index.html.twig', array(
            'events' => $result,
            ));

            }
            else
            {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->redirectToRoute('fos_user_security_login');

    }
    /**
     * Lists all event entities in front.
     *
     * @Route("/front", name="event_indexfront")
     * @Method("GET")
     */
    public function indexfrontAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('EventBundle:Event')->findAll();
        if($request->getMethod() == Request::METHOD_GET) {
            $name = $request->get('filter');
            $events = $this->getDoctrine()->getRepository(Event::class)->mefind($name);
        }
        $query=$events;
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',1)
        );
        return $this->render('@Event/event/indexfront.html.twig', array(
            'events' => $result,
        ));
    }



    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        if($user != null)
        {
            if($user->getRoles()[0] == 'ROLE_ADMIN')
            {
                $event = new Event();
                $form = $this->createForm('EventBundle\Form\EventType', $event);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    /**
                     * @var UploadedFile $file
                     */
                    $file=$event->getEventImg();
                    $fileName=md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('image_directory'),$fileName);
                    //3-cnx avec bd
                   // $event->setEventImg($fileName);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($event);
                    $em->flush();

                    return $this->redirectToRoute('event_show', array('idevent' => $event->getIdevent()));

                }

                return $this->render('@Event/event/new.html.twig', array(
                    'event' => $event,
                    'form' => $form->createView(),
                ));

            }
            else
            {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{idevent}", name="event_show")
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('@Event/event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a event entity in front.
     *
     * @Route("/{idevent}/front", name="event_showfront")
     * @Method("GET")
     */
    public function showfrontAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('@Event/event/showfront.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{idevent}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $user = $this->getUser();
        if($user != null)
        {
            if($user->getRoles()[0] == 'ROLE_ADMIN')
            {
                 $deleteForm = $this->createDeleteForm($event);
                $editForm = $this->createForm('EventBundle\Form\EventType', $event);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                     $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('event_edit', array('idevent' => $event->getIdevent()));
                }

        return $this->render('@Event/event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

            }
            else
            {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{idevent}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $user = $this->getUser();
        if($user != null)
        {
            if($user->getRoles()[0] == 'ROLE_ADMIN')
            {
                $form = $this->createDeleteForm($event);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                     $em = $this->getDoctrine()->getManager();
                     $em->remove($event);
                     $em->flush();
                 }

        return $this->redirectToRoute('event_index');
            }
            else
            {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->redirectToRoute('fos_user_security_login');
    }


    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('idevent' => $event->getIdevent())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Finds and displays an event entity in getEvent.
     *
     * @Route("/getEvent/{idevent}", name="event_getEvent")
     * @Method("GET")
     * @param $idevent
     */
    public function getEventAction($idevent , Request $request){
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EventBundle:Event')->findAll();
        $em = $this->getDoctrine()->getManager();
        $event=$em->getRepository(Event::class)->findOneByIdevent($idevent);
        $user = $this->getUser();
        $verify = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->myfindMe($user, $idevent);
        if($verify ==null){
            if($request->getMethod() == Request::METHOD_GET) {

                if ( $request->get('participer') == "participer"){

                    $participation = new Reservationevent();
                    $participation->setEvent($event);


                    //$idUser = $user->getId();
                    $participation->setUser($user);

                    $nbrePersonnes = $em->getRepository(Event::class)->findOneByIdevent($idevent);

                    $nbre = $nbrePersonnes->getNbrepersonnes();
                    /*
                    $em = $this->getDoctrine()->getManager();
                    //updating place available in randonne table
                    $nbrePersonnes = $em->getRepository(Event::class)->findOneByIdevent($idevent);
                    $nbre = $nbrePersonnes->getNbrepersonnes();
                    */

                    if($nbre == null)
                    {
                        $nbre = 0;
                    }
                    //die('nn: '.$nbrePersonnes->getCapevent().' nbtr: '.$nbre);

                    //verification of number of inscriptions vs capacity
                    if(((int)$nbrePersonnes->getCapevent()) > (int)$nbre )
                    {
                        $new = (int)$nbre+1;
                        //
                        $nbrePersonnes->setNbrepersonnes($new);
                        //$event->setNbrepersonnes($new);
                        //die('nbre actuel: '.$nbrClient[0]->getNbreclient().' new one: '.$new );
                        //die('success');
                    }
                    else
                    {
                        $error = 2;
                    }

                    $em->persist($participation);
                    $em->flush();
                    //bch narja3 lel indexfront

                    $events = $em->getRepository('EventBundle:Event')->findAll();
                    $query=$events;
                    /**
                     * @var $paginator \Knp\Component\Pager\Paginator
                     */
                    $paginator = $this->get('knp_paginator');
                    $result=$paginator->paginate(
                        $query,
                        $request->query->getInt('page',1),
                        $request->query->getInt('limit',1)
                    );
                    return $this->render('@Event/event/indexfront.html.twig', array(
                        'events' => $result,
                    ));
                }
        }

        }



        return $this->render('@Event/event/getEvent.html.twig', array(
            'events'=>$event
        ));
    }

    /**
     * Add a new reservationevent entity in front.
     *
     * @Route("/participateEvent", name="event_participateEvent")
     * @Method({"GET", "POST"})
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function participateEventAction(Request $request, $idevent )
    {

        $user = $this->getUser();


                $idUser = $user->getId();
                    //$idEvent = $event->getIdevent();
                    //die('id event'.$idEvent);
                    $verify = $this->getDoctrine()
                        ->getRepository(Reservationevent::class)
                        ->myfindMe($idUser, $idevent);

                    if($verify == null)
                    {
                        $error = 1;
                        $reservation = new Reservationevent();
                        $reservation->setIdclient($idUser);
                        $reservation->setIdevent($idevent);
                        //die($idUser. ' ra: ' . $idRando);
                        $em = $this->getDoctrine()->getManager();
                        //updating place available in randonne table
                        $nbrePersonnes = $em->getRepository(Event::class)->findOneByIdevent($idevent);

                        $nbre = $nbrePersonnes->getNbrepersonnes();
                    if($nbre == null)
                    {
                        $nbre = 0;
                    }
                    //die('nn: '.$nbrePersonnes->getCapevent().' nbtr: '.$nbre);

                    //verification of number of inscriptions vs capacity
                    if(((int)$nbrePersonnes->getCapevent()) > (int)$nbre )
                    {
                        $new = (int)$nbre+1;
                        //
                        $nbrePersonnes->setNbrepersonnes($new);
                        //$event->setNbrepersonnes($new);
                        //die('nbre actuel: '.$nbrClient[0]->getNbreclient().' new one: '.$new );
                        //die('success');
                    }
                    else
                    {
                        $error = 2;
                    }
                    //Saving in new data DB

                    $em->persist($reservation);
                    $em->flush();
                    return $this->redirectToRoute('event_indexfront');
                }
            }


    /**
     *
     * @Route("/saveevent", name="event_event")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveeventAction(Request $request)
    {

        $user = $this->getUser();
        print $user;
        $old = array();
        $new = array();

        //$event = $this->getIdevent()

        /*$my = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getAllMyEvents($user);*/

        $eventss = array();
        $reservations = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->findBy(['user'=> $user->getId()]);
        $events = array();
        foreach ($reservations as $m){
            array_push($events,$m->getEvent());

           print $m->getEvent()->getNomevent();
           //print 'vv' . $events;
           // $eventss = array($events);

            //print_r($eventss);
        }
        //print $event;
        print ' ';
foreach ($events as $e){
    print $e->getIdevent();
}



        $old = array();
        $new = array();
       /* foreach ($event as $n) {
             $date = $n->getDateevent();
             $Date = \DateTime::createFromFormat('Y-m-d', $date)->format('Y-m-d');
             $today = date("Y-m-d");

             if ($Date > $today)
                 $new[] = $n;
             else
                 $old[] = $n;
         }*/
        return $this->render('@Event/event/saveevent.html.twig', array(
            'my' => $new,
            'old' => $old,
            'events'=>$events,
        ));


    }

}
