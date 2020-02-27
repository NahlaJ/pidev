<?php

namespace ReparationBundle\Controller;

use ReparationBundle\Entity\Reparateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;


/**
 * Reparateur controller.
 *
 */
class ReparateurController extends Controller
{
    /**
     * Lists all reparateur entities.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em = $this->getDoctrine()->getManager();

        $reparateurs = $em->getRepository('ReparationBundle:Reparateur')->findAll();
                $query = $reparateurs;
                /**
                 * @var $paginator \Knp\Component\Pager\Paginator
                 */
                $paginator = $this->get('knp_paginator');
                $result = $paginator->paginate(
                    $query,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 4)
                );

        return $this->render('reparateur/index.html.twig', array(
            'reparateurs' => $result,
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Creates a new reparateur entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $reparateur = new Reparateur();
        $form = $this->createForm('ReparationBundle\Form\ReparateurType', $reparateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $reparateur->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'), $fileName
            );

            $reparateur->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reparateur);
            $em->flush();

            return $this->redirectToRoute('reparateur_show', array('id' => $reparateur->getId()));
        }

        return $this->render('reparateur/new.html.twig', array(
            'reparateur' => $reparateur,
            'form' => $form->createView(),
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Finds and displays a reparateur entity.
     *
     */
    public function showAction(Reparateur $reparateur)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $deleteForm = $this->createDeleteForm($reparateur);

        return $this->render('reparateur/show.html.twig', array(
            'reparateur' => $reparateur,
            'delete_form' => $deleteForm->createView(),
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Displays a form to edit an existing reparateur entity.
     *
     */
    public function editAction(Request $request, Reparateur $reparateur)
    {
        $img=$reparateur->getImage();
        $reparateur->setImage(
            new \Symfony\Component\HttpFoundation\File\File($this->getParameter('image_directory').'/'.$reparateur->getImage()
            ));
        $deleteForm = $this->createDeleteForm($reparateur);
        $editForm = $this->createForm('ReparationBundle\Form\ReparateurType', $reparateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($reparateur->getImage() !== null) {
                /**
                 * @var UploadedFile $file
                 */
                $file = $reparateur->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('image_directory'), $fileName
                );

                $reparateur->setImage($fileName);
            }else
                $reparateur->setImage($img);

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('reparateur_edit', array('id' => $reparateur->getId()));
        }

        return $this->render('reparateur/edit.html.twig', array(
            'reparateur' => $reparateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reparateur entity.
     *
     */
    public function deleteAction(Request $request, Reparateur $reparateur)
    {
        $form = $this->createDeleteForm($reparateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reparateur);
            $em->flush();
        }

        return $this->redirectToRoute('reparateur_index');
    }

    /**
     * Creates a form to delete a reparateur entity.
     *
     * @param Reparateur $reparateur The reparateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reparateur $reparateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reparateur_delete', array('id' => $reparateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function frontindexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reparateurs = $em->getRepository('ReparationBundle:Reparateur')->findAll();

        return $this->render('reparateur/frontindex.html.twig', array(
            'reparateurs' => $reparateurs,
        ));
    }

    public function frontshowAction(Reparateur $reparateur)
    {
        return $this->render('reparateur/frontshow.html.twig', array(
            'reparateur' => $reparateur,

        ));
    }

    public function searchAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $reparateurs = $em->getRepository('ReparationBundle:Reparateur')->findAll();

        if($request->isMethod("POST"))
        {
            $etat = $request->get('status');
            $reparateurs = $em->getRepository('ReparationBundle:Reparateur')->findBy(array('status'=>$etat));
        }
        return $this->render('reparateur/search.html.twig', array(
            'reparateurs' => $reparateurs,
        ));
    }
}
