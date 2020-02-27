<?php

namespace CatalogueBundle\Controller;

use CatalogueBundle\Entity\Promo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Promo controller.
 *
 * @Route("promo")
 */
class PromoController extends Controller
{
    /**
     * Lists all promo entities.
     *
     * @Route("/", name="promo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $end = new \DateTime('now');

        $qb = $em->createQueryBuilder();

        $queryx = $qb->delete('CatalogueBundle:Promo', 'p')
            ->where('p.dateFin < :end')
            ->setParameter('end', $end)
            ->getQuery();

        $queryx->execute();
        $promos = $em->getRepository('CatalogueBundle:Promo')->findAll();

        return $this->render('promo/index.html.twig', array(
            'promos' => $promos,
            'time' => $end,
        ));
    }

    /**
     * Lists all promo entities.
     *
     * @Route("/menu", name="promo_menu")
     * @Method("GET")
     */
    public function MenuAction()
    {
        $end = new \DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $query1 = $em->createQuery('SELECT p FROM CatalogueBundle:Promo p WHERE p.dateDebut <= :end ORDER BY p.dateDebut DESC ')->setParameter('end', $end);
        $promos = $query1->getResult();
        $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p  ORDER BY p.views DESC ');
        $prodViews = $query2->getResult();
        $query3 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p  ORDER BY p.added DESC ');
        $prodDates = $query3->getResult();

        return $this->render('promo/menu.html.twig', array(
            'promos' => $promos,
            'prodViews' => $prodViews,
            'prodDates' => $prodDates,

        ));
    }

    /**
     * Lists all promos entities.
     *
     * @Route("/front", name="promo_front")
     *
     * @Method("GET")
     */
    public function frontAction()
    {
        $em = $this->getDoctrine()->getManager();
        $end = new \DateTime('now');



        $qb = $em->createQueryBuilder();

        $queryx = $qb->delete('CatalogueBundle:Promo', 'p')
            ->where('p.dateFin < :end')
            ->setParameter('end', $end)
            ->getQuery();

        $queryx->execute();
        $query = $em->createQuery('SELECT p FROM CatalogueBundle:Promo p WHERE p.dateDebut <= :end ')->setParameter('end', $end);
        $promos = $query->getResult();

        return $this->render('promo/front.html.twig', array(
            'promos' => $promos,
        ));
    }

    /**
     * Creates a new promo entity.
     *
     * @Route("/new", name="promo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $promo = new Promo();
        $form = $this->createForm('CatalogueBundle\Form\PromoType', $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && ($promo->getDateDebut() < $promo->getDateFin())) {
            $np=$promo->getProduit()->getPrix()*(1-($promo->getRemise()/100));
            $promo->setNewPrix($np);
            $nq=$promo->getProduit()->getQuantite();
            $promo->setQuantite($nq);
            $promo->getProduit()->setPromo($promo);


            $em = $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();

            return $this->redirectToRoute('promo_show', array('id' => $promo->getId()));
        }

        return $this->render('promo/new.html.twig', array(
            'promo' => $promo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a promo entity.
     *
     * @Route("/{id}", name="promo_show")
     * @Method("GET")
     */
    public function showAction(Promo $promo)
    {
        $deleteForm = $this->createDeleteForm($promo);

        return $this->render('promo/show.html.twig', array(
            'promo' => $promo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing promo entity.
     *
     * @Route("/{id}/edit", name="promo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Promo $promo)
    {
        $promo->getProduit()->setPromo(null);
        $deleteForm = $this->createDeleteForm($promo);
        $editForm = $this->createForm('CatalogueBundle\Form\PromoType', $promo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid() && ($promo->getDateDebut() < $promo->getDateFin())){
            $np=$promo->getProduit()->getPrix()*(1-($promo->getRemise()/100));
            $promo->setNewPrix($np);
            $nq=$promo->getProduit()->getQuantite();
            $promo->setQuantite($nq);



            $promo->getProduit()->setPromo($promo);

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('promo_edit', array('id' => $promo->getId()));
        }


        return $this->render('promo/edit.html.twig', array(
            'promo' => $promo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a promo entity.
     *
     * @Route("/{id}", name="promo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Promo $promo)
    {
        $form = $this->createDeleteForm($promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promo);
            $em->flush();
        }

        return $this->redirectToRoute('promo_index');
    }



    /**
     * Creates a form to delete a promo entity.
     *
     * @param Promo $promo The promo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Promo $promo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promo_delete', array('id' => $promo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
