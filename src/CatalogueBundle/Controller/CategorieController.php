<?php

namespace CatalogueBundle\Controller;

use CatalogueBundle\Entity\Categorie;
use GuzzleHttp\Psr7\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categorie controller.
 *
 * @Route("categorie")
 */
class CategorieController extends Controller
{
    /**
     * Lists all categorie entities.
     *
     * @Route("/", name="categorie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('CatalogueBundle:Categorie')->findAll();

        return $this->render('categorie/index.html.twig', array(
            'categories' => $categories,
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Lists all categorie entities.
     *
     * @Route("/front", name="categorie_front")
     * @Method("GET")
     */
    public function frontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('CatalogueBundle:Categorie')->findAll();

        return $this->render('categorie/front.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Lists all categorie entities.
     *
     * @Method("GET")
     */
    public function frontpAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('CatalogueBundle:Categorie')->findAll();

        return $this->render('produit/front.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new categorie entity.
     *
     * @Route("/new", name="categorie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $categorie = new Categorie();
        $form = $this->createForm('CatalogueBundle\Form\CategorieType', $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$categorie->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'),$fileName
            );

            $categorie->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('categorie_show', array('id' => $categorie->getId()));
        }

        return $this->render('categorie/new.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * Finds and displays a categorie entity.
     *
     * @Route("/{id}", name="categorie_show")
     * @Method("GET")
     */
    public function showAction(Categorie $categorie)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $deleteForm = $this->createDeleteForm($categorie);

        return $this->render('categorie/show.html.twig', array(
            'categorie' => $categorie,
            'delete_form' => $deleteForm->createView(),
        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }



    /**
     * Displays a form to edit an existing categorie entity.
     *
     * @Route("/{id}/edit", name="categorie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categorie $categorie)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $img=$categorie->getImage();
        $categorie->setImage(
            new File($this->getParameter('image_directory').'/'.$categorie->getImage()
            ));
        $deleteForm = $this->createDeleteForm($categorie);
        $editForm = $this->createForm('CatalogueBundle\Form\CategorieType', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //Check if new image was uploaded
            if($categorie->getImage() !== null) {
                //Type hint
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $newImage*/
                $newImage=$categorie->getImage();
                $newImageName= md5(uniqid()).'.'.$newImage->guessExtension();
                $newImage->move($this->getParameter('image_directory'), $newImageName);
                $categorie->setImage($newImageName);
            } else {
                //Restore old file name
                $categorie->setImage($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_edit', array('id' => $categorie->getId()));
        }

        return $this->render('categorie/edit.html.twig', array(
            'categorie' => $categorie,
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
     * Deletes a categorie entity.
     *
     * @Route("/{id}", name="categorie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Categorie $categorie)
    {
        $form = $this->createDeleteForm($categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();
        }

        return $this->redirectToRoute('categorie_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Categorie $categorie The categorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categorie $categorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorie_delete', array('id' => $categorie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
