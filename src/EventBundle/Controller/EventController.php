<?php

namespace EventBundle\Controller;

use DateTime;
use EventBundle\Entity\Event;
use EventBundle\Entity\Reservationevent;
use EventBundle\EventBundle;
use EventBundle\Form\EventaddType;
use EventBundle\Form\EventupType;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use EventBundle\Repository\EventRepository;
use UserBundle\Entity\User;


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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
                $em = $this->getDoctrine()->getManager();

                $events = $em->getRepository('EventBundle:Event')->findAll();


                $query = $events;
                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                $paginator = $this->get('knp_paginator');
                $result = $paginator->paginate(
                    $query,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 3)
                );

                if ($request->getMethod() == Request::METHOD_GET) {

                    if ($request->get('TELECHARGER_PDF') == "TELECHARGER_PDF") {

                        $snappy = new Pdf('C:\pic_2018\wkhtmltopdf\bin\wkhtmltopdf');
                        $html = "<style>
          .clearfix:after {
  content: \"\";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}</style>
<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <title>Example 1</title>
    <link rel=\"stylesheet\" href=\"style.css\" media=\"all\" />
  </head>
  <body>
    <header class=\"clearfix\">
      <div id=\"logo\">
        <img src=\"logo.png\">
      </div>
      <h1>EVENTS LIST</h1>
      <div id=\"company\" class=\"clearfix\">
        <div>Cycle.tn</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href=\"mailto:company@example.com\">cycle@gmail.com</a></div>
      </div>
      
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class=\"service\">NAME EVENT</th>
            <th class=\"desc\">DESCRIPTION</th>
            <th>PLACE</th>
            <th>PRICE</th>
            <th>CAPACITY</th> 
          </tr>
        </thead>
        <tbody>";
                        foreach ($events as $e) {
                            $html = $html . "<tr>
            <td class=\"service\">" . $e->getNomevent() . "</td>
            <td class=\"desc\">" . $e->getDescription() . "</td>
            <td class=\"unit\">" . $e->getLieuevent() . "</td>
            <td class=\"qty\">" . $e->getTicketprice() . "</td>
            <td class=\"total\">" . $e->getCapevent() . "</td>
          </tr>";

                        }
                        $html = $html . "
          
        </tbody>
      </table>
      <div id=\"notices\">
        <div>NOTICE:</div>
        <div class=\"notice\">HAVE A NICE DAY</div>
      </div>
    </main>
    <footer>
     CYCLE.TN
    </footer>
  </body>
</html>";
                        $snappy->generateFromHtml($html, '/tmp/nahla.pdf');
                        return $this->render('@Event/event/index.html.twig', array(
                            'events' => $result,
                        ));
                    }
                }

                return $this->render('@Event/event/index.html.twig', array(
                    'events' => $result,
                ));

            } else {
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
        if ($request->getMethod() == Request::METHOD_GET) {
            $name = $request->get('filter');
            $events = $this->getDoctrine()->getRepository(Event::class)->mefind($name);
        }
        $query = $events;
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 1)
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
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
                $event = new Event();
                $form = $this->createForm('EventBundle\Form\EventType', $event);
                $form->handleRequest($request);
                /* $basic  = new \Nexmo\Client\Credentials\Basic('a5a703ea', 'o4nIMO8eCrbXP76E');
                 $client = new \Nexmo\Client($basic);
                 $message = $client->message()->send([
                     'to' => '21694899540',
                     'from' => 'kid o',
                     'text' => 'Salut, un evenement a été ajouté, merci de le consulter et passez une bonne journée ',
                 ]);*/

                if ($form->isSubmitted() && $form->isValid()) {


                    $file = $form['eventImg']->getData();
                    $file->move('images/', $file->getClientOriginalName());
                    $event->setEventImg('' . $file->getClientOriginalName());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($event);
                    $em->flush();

                    return $this->redirectToRoute('event_show', array('idevent' => $event->getIdevent()));

                }

                return $this->render('@Event/event/new.html.twig', array(
                    'event' => $event,
                    'form' => $form->createView(),
                ));

            } else {
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
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
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

            } else {
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
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
                $form = $this->createDeleteForm($event);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($event);
                    $em->flush();
                }

                return $this->redirectToRoute('event_index');
            } else {
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
            ->getForm();
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
    public function participateEventAction(Request $request, $idevent)
    {

        $user = $this->getUser();


        $idUser = $user->getId();
        //$idEvent = $event->getIdevent();
        //die('id event'.$idEvent);
        $verify = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->myfindMe($idUser, $idevent);

        if ($verify == null) {
            $error = 1;
            $reservation = new Reservationevent();
            $reservation->setIdclient($idUser);
            $reservation->setIdevent($idevent);
            //die($idUser. ' ra: ' . $idRando);
            $em = $this->getDoctrine()->getManager();
            //updating place available in randonne table
            $nbrePersonnes = $em->getRepository(Event::class)->findOneByIdevent($idevent);

            $nbre = $nbrePersonnes->getNbrepersonnes();
            if ($nbre == null) {
                $nbre = 0;
            }
            //die('nn: '.$nbrePersonnes->getCapevent().' nbtr: '.$nbre);

            //verification of number of inscriptions vs capacity
            if (((int)$nbrePersonnes->getCapevent()) > (int)$nbre) {
                $new = (int)$nbre + 1;
                //
                $nbrePersonnes->setNbrepersonnes($new);
                //$event->setNbrepersonnes($new);
                //die('nbre actuel: '.$nbrClient[0]->getNbreclient().' new one: '.$new );
                //die('success');
            } else {
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
     * @Method({"GET", "POST","DELETE"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveeventAction(Request $request)
    {
        $user = $this->getUser();
        $reservations = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->findBy(['user' => $user->getId()]);
        /*$em = $this->getDoctrine()->getManager();
        $nn = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->findBy(['user' => $user->getId()]);
        //$idevent=$nn->getEvent();*/
        //$event = $em->getRepository(Event::class)->findOneByIdevent($idevent);
        $events = array();
        $old = array();
        $new = array();

        foreach ($reservations as $m) {
            array_push($events, $m->getEvent());}

        /*
        if ($request->getMethod() == Request::METHOD_GET) {

            if ($request->get('cancel') == "cancel") {

                $reservations = $this->getDoctrine()
                    ->getRepository(Reservationevent::class)
                    ->findBy(['user' => $user->getId()]);
                $paricipants = array();
                $events = array();
                foreach ($reservations as $m) {
                    array_reduce($events, $m->getEvent());}


                //$reservation =$em->getRepository(Reservationevent::class)->myFindMe($user,$idevent);
                $em->remove($events);


                $this->getDoctrine()->getManager()->flush();
                $em->flush();


            }


        }*/
        return $this->render('@Event/event/saveevent.html.twig', array(
            'events' => $events,
            'my' => $new,
            'old' => $old,
        ));

    }


    /**
     * Finds and displays an event entity in getEvent.
     *
     * @Route("/getEvent/{idevent}", name="event_getEvent")
     * @Method("GET")
     * @param $idevent
     */
    public function getEventAction($idevent, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EventBundle:Event')->findAll();
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->findOneByIdevent($idevent);
        $user = $this->getUser();
        $verify = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->myfindMe($user, $idevent);
        if ($verify == null) {
            if ($request->getMethod() == Request::METHOD_GET) {

                if ($request->get('participer') == "participer") {

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

                    if ($nbre == null) {
                        $nbre = 0;
                    }
                    //die('nn: '.$nbrePersonnes->getCapevent().' nbtr: '.$nbre);

                    //verification of number of inscriptions vs capacity
                    if (((int)$nbrePersonnes->getCapevent()) > (int)$nbre) {
                        $new = (int)$nbre + 1;
                        //
                        $nbrePersonnes->setNbrepersonnes($new);
                        //$event->setNbrepersonnes($new);
                        //die('nbre actuel: '.$nbrClient[0]->getNbreclient().' new one: '.$new );
                        //die('success');
                    } else {
                        $error = 2;
                    }

                    $em->persist($participation);
                    $em->flush();
                    //bch narja3 lel indexfront

                    $events = $em->getRepository('EventBundle:Event')->findAll();
                    $query = $events;
                    /**
                     * @var $paginator \Knp\Component\Pager\Paginator
                     */
                    $paginator = $this->get('knp_paginator');
                    $result = $paginator->paginate(
                        $query,
                        $request->query->getInt('page', 1),
                        $request->query->getInt('limit', 1)
                    );

                    return $this->render('@Event/event/indexfront.html.twig', array(
                        'events' => $result,
                    ));
                }

            }
        }


        return $this->render('@Event/event/getEvent.html.twig', array(
            'events' => $event
        ));
    }


    /**
     *
     * @Route("/users", name="event_users")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function usersAction(Request $request)
    {
        $user = $this->getUser();
        //print $user;

        $reservations = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->findBy(['user' => $user->getId()]);
        $paricipants = array();
        $events = array();
        foreach ($reservations as $m) {
            array_push($paricipants ,$m->getUser());
           array_push($events, $m->getEvent());}


            return $this->render('@Event/event/users.html.twig', array(
                'paricipants' => $paricipants,
                'events' => $events,
            ));

            /*
            $user = $this->getUser();
            if($user == null )
                return $this->redirectToRoute('fos_user_security_login');
            if($user->getRoles()[0] == 'ROLE_USER')
                return $this->redirectToRoute('http://localhost/A+/sprint1/web/app_dev.php/MainView/MainIndex');
            else
            {
                print 'k';
                $em = $this->getDoctrine()->getManager();
                $users = $em->getRepository(User::class)->findAll();

                //die("nbre: ".print_r($enabled));



                return $this->render('@Event/event/users.html.twig',array(
                    'users' => $users,
                ));
            }*/

    }

}
