<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\Location;
use LocationBundle\Entity\Velo;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Location controller.
 *
 */
class LocationController extends Controller
{
    /**
     * Lists all location entities.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index1Action(Request $request)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('LocationBundle:Location')->findAll();
                if ($request->getMethod() == Request::METHOD_GET) {

                    if ($request->get('TELECHARGER_PDF') == "TELECHARGER_PDF") {

                        $snappy = new Pdf('C:\wkhtmltopdf\bin\wkhtmltopdf');
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
      <h1>LOCATION</h1>
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
            <th>ID LOCATION</th>
            <th>PRICE</th>
          </tr>
        </thead>
        <tbody>";
                        foreach ($locations as $e) {
                            $html = $html . "<tr>
            <td>" . $e->getId() . "</td>
            <td>" . $e->getPrix() . "</td>
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
                        $snappy->generateFromHtml($html, '/tmp/location.pdf');

                    }
                }

        return $this->render('location/index1.html.twig', array(
            'locations' => $locations,
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Creates a new location entity.
     *
     */
    public function new1Action(Request $request,UserInterface $user ,Velo $velo)
    {
        $location = new Location();

        $form = $this->createForm('LocationBundle\Form\LocationType', $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {





            $em = $this->getDoctrine()->getManager();

            $location->setUser($user);
            $location->setVelo($velo);
            $diff = date_diff( $location->getDateFin(), $location->getDateDebut());
            $a =  $diff->format("%h");
            $location->setPrix($velo->getPrix() + 20 *$a);
            $em->persist($location);
            $em->flush();

            $manager = $this->get('mgilet.notification');
            $notif = $manager->createNotification('Hello world!');
            $notif->setMessage('This a notification.');

            $manager->addNotification(array($this->getUser()), $notif, true);

            return $this->redirectToRoute('location_show1', array('id' => $location->getId()));
        }

        return $this->render('location/new1.html.twig', array(
            'location' => $location,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a location entity.
     * @param Location $location
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
       public function show1Action(Location $location, Request $request)
    {

        $deleteForm = $this->createDeleteForm($location);



        return $this->render('location/show1.html.twig', array(
            'location' => $location,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Finds and displays a location entity.
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function show1FrontAction($id, Request $request)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em= $this->getDoctrine()->getManager();
        $p=$em->getRepository('LocationBundle:Location')->find($id);

        return $this->render('Location/show1Front.html.twig', array(
            'dateDebut'=>$p->getDateDebut(),
            'DateFin'=>$p->getDateFin(),
            'prix'=>$p->getPrix(),
            'id'=>$p->getId(),
            'location'=> $p
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }
    /**
     * Displays a form to edit an existing location entity.
     *
     */
    public function editAction(Request $request, Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);
        $editForm = $this->createForm('LocationBundle\Form\LocationType', $location);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_edit', array('id' => $location->getId()));
        }

        return $this->render('location/edit.html.twig', array(
            'location' => $location,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a location entity.
     *
     */
    public function deleteAction(Request $request, Location $location)
    {
        $form = $this->createDeleteForm($location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($location);
            $em->flush();
        }

        return $this->redirectToRoute('location_index');
    }

    /**
     * Creates a form to delete a location entity.
     *
     * @param Location $location The location entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Location $location)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('location_delete', array('id' => $location->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
