<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\Velo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VeloBundle\Form\VeloType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Velo controller.
 *
 */
class VeloController extends Controller
{
    /**
     * Lists all velo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $velos = $em->getRepository('LocationBundle:Velo')->findAll();

        return $this->render('velo/index.html.twig', array(
            'velos' => $velos,
        ));
    }
    /**
     * Lists all velo entities.
     *
     */
    public function indexFrontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $velos = $em->getRepository('LocationBundle:Velo')->confirmedVelo();

        return $this->render('velo/indexFront.html.twig', array(
            'velos' => $velos,
        ));
    }

    /**
     * Creates a new velo entity.
     *
     */
    public function newAction(Request $request)
    {
        $velo = new Velo();
        $form = $this->createForm('LocationBundle\Form\VeloType', $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $velo->getImage();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('images_directory'),$filename);
            $velo->setImage($filename);

            $em->persist($velo);
            $em->flush();

            return $this->redirectToRoute('velo_new', array('id' => $velo->getId()));
        }

        return $this->render('velo/new.html.twig', array(
            'velo' => $velo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a velo entity.
     *
     */
    public function showAction(Velo $velo)
    {
        $deleteForm = $this->createDeleteForm($velo);

        return $this->render('velo/show.html.twig', array(
            'velo' => $velo,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Finds and displays a velo entity.
     *
     */
    public function showfrontAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $v=$em->getRepository('LocationBundle:Velo')->find($id);
        return $this->render('Velo/showFront.html.twig', array(
            'marque'=>$v->getMarque(),
            'caracteristiques'=>$v->getCaracteristiques(),
            'image'=>$v->getImage(),
            'age'=>$v->getAge(),
            'compteur'=>$v->getCompteur(),
            'id'=>$v->getId(),
            'velos'=>$v,
        ));
    }




    /**
     * Displays a form to edit an existing velo entity.
     *
     */
    public function editAction(Request $request, Velo $velo)
    {
        $deleteForm = $this->createDeleteForm($velo);
        $editForm = $this->createForm('LocationBundle\Form\VeloType', $velo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('velo_edit', array('id' => $velo->getId()));
        }

        return $this->render('velo/edit.html.twig', array(
            'velo' => $velo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a velo entity.
     *
     */
    public function deleteAction(Request $request, Velo $velo)
    {
        $form = $this->createDeleteForm($velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($velo);
            $em->flush();
        }

        return $this->redirectToRoute('velo_index');
    }

    /**
     * Creates a form to delete a velo entity.
     *
     * @param Velo $velo The velo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Velo $velo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('velo_delete', array('id' => $velo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $velos =  $em->getRepository('LocationBundle:Velo')->findEntitiesByString($requestString);
        if(!$velos) {
            $result['velos']['error'] = "Post Not found  ";
        } else {
            $result['velos'] = $this->getRealEntities($velos);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($velos){
        foreach ($velos as $velos){
            $realEntities[$velos->getId()] = [$velos->getImage(),$velos->getMarque()];
        }
        return $realEntities;
    }
    public function accepterAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $velo=$em->getRepository('LocationBundle:Velo')->find($id);
        $velo->setEtat(0);
        $em->flush();


        return $this->redirectToRoute('velo_index');

    }
}
