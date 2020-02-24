<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\Location;
use LocationBundle\Entity\Velo;
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
     *
     */
    public function index1Action()
    {
        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository('LocationBundle:Location')->findAll();

        return $this->render('location/index1.html.twig', array(
            'locations' => $locations,
        ));
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

            $em->persist($location);
            $em->flush();

            /*$manager = $this->get('mgilet.notification');
            $notif = $manager->createNotification('Hello world!');
            $notif->setMessage('This a notification.');

            $manager->addNotification(array($this->getUser()), $notif, true);*/




            return $this->redirectToRoute('location_show1', array('id' => $location->getId()));
        }

        return $this->render('location/new1.html.twig', array(
            'location' => $location,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a location entity.
     *
     */
       public function show1Action(Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);

        return $this->render('location/show1.html.twig', array(
            'location' => $location,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Finds and displays a location entity.
     *
     */
    public function show1FrontAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $p=$em->getRepository('LocationBundle:Location')->find($id);
        return $this->render('Location/show1Front.html.twig', array(
            'dateDebut'=>$p->getDateDebut(),
            'DateFin'=>$p->getDateFin(),
            'prix'=>$p->getPrix(),
            'id'=>$p->getId(),
            'location'=> $p
        ));
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
