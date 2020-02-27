<?php

namespace ReparationBundle\Controller;

use ReparationBundle\Entity\Reparateur;
use ReparationBundle\Entity\VeloAReparer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

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
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em = $this->getDoctrine()->getManager();

        $veloAReparers = $em->getRepository('ReparationBundle:VeloAReparer')->findAll();

        return $this->render('veloareparer/index.html.twig', array(
            'veloAReparers' => $veloAReparers,
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Lists all veloAReparer entities.
     *
     */
    public function singleAction()
    {
        $em = $this->getDoctrine()->getManager();

        $veloAReparers = $em->getRepository('ReparationBundle:VeloAReparer')->findAll();

        return $this->render('veloareparer/maintenance.html.twig', array(
            'veloAReparers' => $veloAReparers,
        ));
    }

    /**
     * Creates a new veloAReparer entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
            $veloAReparer = new Veloareparer();
            $form = $this->createForm('ReparationBundle\Form\VeloAReparerType', $veloAReparer);
            $form->handleRequest($request);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var UploadedFile $file
                 */
                $file = $veloAReparer->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('image_directory'), $fileName
                );

                $veloAReparer->setImage($fileName);
                $toom= new \DateTime('now');
                $veloAReparer->setDateR($toom);
                $veloAReparer->setUser($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($veloAReparer);
                $em->flush();

                return $this->redirectToRoute('veloR_new', array('id' => $veloAReparer->getId()));
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
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $deleteForm = $this->createDeleteForm($veloAReparer);

        return $this->render('veloareparer/show.html.twig', array(
            'veloAReparer' => $veloAReparer,
            'delete_form' => $deleteForm->createView(),
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Displays a form to edit an existing veloAReparer entity.
     *
     */
    public function editAction(Request $request, VeloAReparer $veloAReparer)
    {
        $img=$veloAReparer->getImage();
        $veloAReparer->setImage(
            new \Symfony\Component\HttpFoundation\File\File($this->getParameter('image_directory').'/'.$veloAReparer->getImage()
            ));
        $deleteForm = $this->createDeleteForm($veloAReparer);
        $editForm = $this->createForm('ReparationBundle\Form\VeloAReparerType', $veloAReparer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $veloAReparer->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'), $fileName
            );

            $veloAReparer->setImage($fileName);
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
    public function affectAction(VeloAReparer $veloAReparer , Request $request)
    {
        $reps = $this->getDoctrine()->getRepository(Reparateur::class)->findBy(['status'=> 'libre']);
        if ($request->getMethod() == Request::METHOD_POST){
            print $request->request->get('rep');
            $myRep = $this->getDoctrine()->getRepository(Reparateur::class)->find($request->request->get('rep'));
            $veloAReparer->setReparateur($myRep);
            $myRep->setStatus("occupé");
            $myRep->setNbrVeloRepare($myRep->getNbrVeloRepare() + 1);
            $veloAReparer->setStatus("Work in progress");
            $this->getDoctrine()->getManager()->persist($myRep);
            $this->getDoctrine()->getManager()->persist($veloAReparer);
            $this->getDoctrine()->getManager()->persist($veloAReparer);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('veloR_index');

        }
        return $this->render('veloareparer/affecter.html.twig',array('reps'=> $reps));
    }

    public function  endRepAction($id, VeloAReparer $veloAReparer){
        $monVelo = $this->getDoctrine()->getRepository(VeloAReparer::class)->find($id);

        $rep = $this->getDoctrine()->getRepository(Reparateur::class)->find($monVelo->getReparateur()->getId());
        $rep->setStatus('libre');
        $monVelo->setRepNull();
        $veloAReparer->setStatus("Done");

        $this->getDoctrine()->getManager()->persist($monVelo);
        $this->getDoctrine()->getManager()->persist($rep);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('veloR_index');
    }
}
