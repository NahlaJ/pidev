<?php

namespace ReparationBundle\Controller;

use ReparationBundle\Entity\VeloAReparer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Veloareparer controller.
 *
 */
class VeloAReparerController extends Controller
{
    /**
     * Lists all veloAReparer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $veloAReparers = $em->getRepository('ReparationBundle:VeloAReparer')->findAll();

        return $this->render('veloareparer/index.html.twig', array(
            'veloAReparers' => $veloAReparers,
        ));
    }

    /**
     * Creates a new veloAReparer entity.
     *
     */
    public function newAction(Request $request)
    {
        $veloAReparer = new Veloareparer();
        $form = $this->createForm('ReparationBundle\Form\VeloAReparerType', $veloAReparer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($veloAReparer);
            $em->flush();

            return $this->redirectToRoute('veloR_show', array('id' => $veloAReparer->getId()));
        }

        return $this->render('veloareparer/new.html.twig', array(
            'veloAReparer' => $veloAReparer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a veloAReparer entity.
     *
     */
    public function showAction(VeloAReparer $veloAReparer)
    {
        $deleteForm = $this->createDeleteForm($veloAReparer);

        return $this->render('veloareparer/show.html.twig', array(
            'veloAReparer' => $veloAReparer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing veloAReparer entity.
     *
     */
    public function editAction(Request $request, VeloAReparer $veloAReparer)
    {
        $deleteForm = $this->createDeleteForm($veloAReparer);
        $editForm = $this->createForm('ReparationBundle\Form\VeloAReparerType', $veloAReparer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('veloR_edit', array('id' => $veloAReparer->getId()));
        }

        return $this->render('veloareparer/edit.html.twig', array(
            'veloAReparer' => $veloAReparer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a veloAReparer entity.
     *
     */
    public function deleteAction(Request $request, VeloAReparer $veloAReparer)
    {
        $form = $this->createDeleteForm($veloAReparer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($veloAReparer);
            $em->flush();
        }

        return $this->redirectToRoute('veloR_index');
    }

    /**
     * Creates a form to delete a veloAReparer entity.
     *
     * @param VeloAReparer $veloAReparer The veloAReparer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VeloAReparer $veloAReparer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('veloR_delete', array('id' => $veloAReparer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
