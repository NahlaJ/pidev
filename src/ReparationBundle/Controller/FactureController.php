<?php

namespace ReparationBundle\Controller;

use ReparationBundle\Entity\Facture;
use ReparationBundle\Entity\Reparateur;
use ReparationBundle\Entity\VeloAReparer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;

/**
 * Facture controller.
 *
 */
class FactureController extends Controller
{
    /**
     * Lists all facture entities.
     *
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em = $this->getDoctrine()->getManager();

        $factures = $em->getRepository('ReparationBundle:Facture')->findAll();

        return $this->render('facture/index.html.twig', array(
            'factures' => $factures,
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Creates a new facture entity.
     *
     */
    public function newAction(Request $request )
    {

        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $input=$request->get('id');
        $facture = new Facture();
        $form = $this->createForm('ReparationBundle\Form\FactureType', $facture);
        $form->handleRequest($request);
        $monVelo = $this->getDoctrine()->getRepository(VeloAReparer::class)->find($input);

        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setVeloAReparer($monVelo);
            $facture->getVeloAReparer()->setFacture($facture);
            $rep = $this->getDoctrine()->getRepository(Reparateur::class)->find($facture->getVeloAReparer()->getReparateur()->getId());
            $rep->setStatus('libre');
            $facture->getVeloAReparer()->setRepNull();
            $facture->getVeloAReparer()->setStatus("Done");

            $em = $this->getDoctrine()->getManager();
            $em->persist($facture);
            $em->persist($rep);
            $em->flush();

            return $this->redirectToRoute('facture_show', array('id' => $facture->getId()));
        }

        return $this->render('facture/new.html.twig', array(
            'facture' => $facture,
            'form' => $form->createView(),
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Finds and displays a facture entity.
     *
     */
    public function showAction(Facture $facture)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $deleteForm = $this->createDeleteForm($facture);

        return $this->render('facture/show.html.twig', array(
            'facture' => $facture,
            'delete_form' => $deleteForm->createView(),
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Displays a form to edit an existing facture entity.
     *
     */
    public function editAction(Request $request, Facture $facture)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $deleteForm = $this->createDeleteForm($facture);
        $editForm = $this->createForm('ReparationBundle\Form\FactureType', $facture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_edit', array('id' => $facture->getId()));
        }

        return $this->render('facture/edit.html.twig', array(
            'facture' => $facture,
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
     * Deletes a facture entity.
     *
     */
    public function deleteAction(Request $request, Facture $facture)
    {
        $form = $this->createDeleteForm($facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facture);
            $em->flush();
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * Creates a form to delete a facture entity.
     *
     * @param Facture $facture The facture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Facture $facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $facture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function pdfAction(Facture $facture)
    {

        $snappy = new Pdf('C:\wkhtmltopdf\bin\wkhtmltopdf');
        $html = $this->renderView("facture/pdf.html.twig", array(
            'facture' => $facture,
            "title" => "Facture"
        ));
        $filename ="pdf_from_twig";
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    public function checkAction(Facture $facture)
    {
        $deleteForm = $this->createDeleteForm($facture);

        return $this->render('facture/showfront.html.twig', array(
            'facture' => $facture,
            'delete_form' => $deleteForm->createView(),
        ));
    }


}
