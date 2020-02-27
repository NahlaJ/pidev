<?php

namespace CatalogueBundle\Controller;

use CatalogueBundle\Entity\Produit;
use CatalogueBundle\Entity\Categorie;
use CatalogueBundle\Entity\ProduitRating;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use GuzzleHttp\Psr7\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Produit controller.
 *
 * @Route("produit")
 */
class ProduitController extends Controller
{

    /**
     * Lists all produit entities.
     *
     * @Route("/rate/{id}", name="produit_rate")
     * Is_Granted('IS_AUTHENTICATED_FULLY')
     * @Method({"GET", "POST"})
     */
    public function rateAction(Request $request , Produit $produit)
    {
        $em=$this->getDoctrine()->getManager();
        $pr=new ProduitRating();
        $form = $this->createForm('CatalogueBundle\Form\ProduitRatingType', $pr);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $pr->setUser($user);
                $pr->setProduit($produit);
                $em->persist($pr);
                $em->flush();
                return $this->redirectToRoute('produit_single', array('id' => $produit->getId()));
            }
        }
        return $this->render('produit/rateProduit.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView()
        ));



    }
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="produit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('CatalogueBundle:Produit')->findAll();
        $pieChart = new PieChart();

        $em = $this->getDoctrine()->getManager();

        $queryx = $em->createQuery("SELECT p.nom ,p.views FROM CatalogueBundle:Produit p ");
        $views = $queryx->getResult();

        $pieChart->getData()->setArrayToDataTable($views,'nom','views');
        $pieChart->getOptions()->setTitle('Most viewed Product');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        $queryy = $em->createQuery("SELECT p.nom ,p.quantite FROM CatalogueBundle:Produit p ");
        $quantite = $queryy->getResult();

        $pieChartq = new PieChart();
        $pieChartq->getData()->setArrayToDataTable($quantite,'nom','quantite');
        $pieChartq->getOptions()->setTitle('Products quantities');
        $pieChartq->getOptions()->setHeight(500);
        $pieChartq->getOptions()->setWidth(900);
        $pieChartq->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChartq->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChartq->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChartq->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChartq->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
            'piechart' => $pieChart,
            'piechartq' =>$pieChartq,
        ));
    }

    /**
     * Lists all produit entities.
     *
     * @Route("/c/{id}", name="produit_trier")
     * @Method("GET")
     */
    public function trierParCategorieAction(Request $request)
    {
        $input=$request->get('id');

        $em=$this->getDoctrine()->getManager();
        $categorie=$em->getRepository("CatalogueBundle:Categorie")->findById($input);
        $produits = $em->getRepository('CatalogueBundle:Produit')->findBy(array('Categorie'=>$input));
        $categories = $em->getRepository('CatalogueBundle:Categorie')->findAll();
        $now = new \DateTime('now');


        return $this->render('produit/frontTrier.html.twig', array(
            'produits' => $produits,
            'categories' => $categories,
            'now'=> $now,
        ));
    }


    /**
     * Lists all produit entities.
     *
     * @Route("/front/tri/{id}", name="produit_tri")
     * @Method("GET")
     */
    public function trierAction(Request $request)
    {
        $now = new \DateTime('now');

        $input=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('CatalogueBundle:Categorie')->findAll();

        if ($input==1){
        $query1 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.sexe =:Men')->setParameter(':Men', 'Men');
        $sexe = $query1->getResult();}
        elseif ($input==2)
        {
        $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.sexe =:Women')->setParameter(':Women', 'Women');;
        $sexe = $query2->getResult();
        }
        elseif ($input==3)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.type =:Women')->setParameter(':Women', 'Sport');;
            $sexe = $query2->getResult();
        }
        elseif ($input==4)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.type =:Women')->setParameter(':Women', 'Mountain');;
            $sexe = $query2->getResult();
        }
        elseif ($input==5)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.type =:Women')->setParameter(':Women', 'Popular');;
            $sexe = $query2->getResult();
        }
        elseif ($input==6)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.type =:Women')->setParameter(':Women', 'Kids');;
            $sexe = $query2->getResult();
        }
        elseif ($input==7)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.type =:Women')->setParameter(':Women', 'Special');;
            $sexe = $query2->getResult();
        }
        elseif ($input==8)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.prix < 50 ');
            $sexe = $query2->getResult();
        }
        elseif ($input==9)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.prix > 49 AND p.prix < 100 ');
            $sexe = $query2->getResult();
        }
        elseif ($input==10)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.prix > 99 AND p.prix < 200 ');
            $sexe = $query2->getResult();
        }
        elseif ($input==11)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.prix > 199 AND p.prix < 500 ');
            $sexe = $query2->getResult();
        }
        elseif ($input==12)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.prix > 499 AND p.prix < 1000 ');
            $sexe = $query2->getResult();
        }
        elseif ($input==13)
        {
            $query2 = $em->createQuery('SELECT p FROM CatalogueBundle:Produit p WHERE p.prix > 999 ');
            $sexe = $query2->getResult();
        }

        return $this->render('produit/Tri.html.twig', array(
            'produits' => $sexe,
            'categories' => $categories,
            'now' => $now,

        ));
    }

    /**
     * Lists all produit entities.
     *
     * @Route("/front", name="produit_front")
     * @Method("GET")
     */
    public function frontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('CatalogueBundle:Produit')->findAll();
        $categories = $em->getRepository('CatalogueBundle:Categorie')->findAll();
        $now = new \DateTime('now');


        return $this->render('produit/front.html.twig', array(
            'produits' => $produits,
            'categories' => $categories,
            'now'=> $now,
        ));
    }

    /**
     * Lists all produit entities.
     *
     * @Route("/test/ajax", name="produit_test")
     */

    public function ajaxAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('CatalogueBundle:Produit')->findAll();

        if ($request->isXmlHttpRequest()) {
            $jsonData = array();
            $idx = 0;
            foreach ($produits as $produit) {
                $temp = array(
                    'id' => $produit->getId(),
                    'nom' => $produit->getNom(),
                    'prix' => $produit->getPrix(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('produit/ajax.html.twig');

        }
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="produit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('CatalogueBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$produit->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'),$fileName
            );

            $produit->setImage($fileName);
            $end = new \DateTime('now');
            $produit->setAdded($end);
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('id' => $produit->getId()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/send/mail", name="produit_mail")
     */
    public function mailAction()
    {
        $message =(new \Swift_Message('hhhhhhhh'))
            ->setFrom('youssefxhaffar@gmail.com')
            ->setTo('mohamedyoussef.haffar@esprit.tn')
            ->setBody('ya3tek 3asba ');
        $this->get('mailer')->send($message);
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{id}", name="produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/p/{id}", name="produit_single")
     * @Method("GET")
     */
    public function singleAction(Produit $produit)
    {
        $now= new \DateTime('now');
        $em=$this->getDoctrine()->getManager();
        $rates  = $em->getRepository('CatalogueBundle:ProduitRating')->findBy(array('produit'=>$produit->getId()));
        $moy = 0 ;
        if(count($rates)> 0){
            foreach ($rates as $r){
                $moy +=$r->getRating();
            }
            $moy = $moy/count($rates);
        }
        $query = $em->createQuery("SELECT p FROM CatalogueBundle:Promo p JOIN p.produit t WHERE t.id IN (:id) ")
            ->setParameter('id', $produit->getId());
        $promos = $query->getResult();

        $produit->setViews($produit->getViews()+1);
        $em->persist($produit);
        $em->flush();

        return $this->render('produit/single.html.twig', array(
            'produit' => $produit,
            'promos' => $promos,
            'moy' => $moy,
            'now' => $now,
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{id}/edit", name="produit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produit $produit)
    {
        $img=$produit->getImage();
        $produit->setImage(
            new File($this->getParameter('image_directory').'/'.$produit->getImage()
            ));
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('CatalogueBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //Check if new image was uploaded
            if($produit->getImage() !== null) {
                //Type hint
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $newImage*/
                $newImage=$produit->getImage();
                $newImageName= md5(uniqid()).'.'.$newImage->guessExtension();
                $newImage->move($this->getParameter('image_directory'), $newImageName);
                $produit->setImage($newImageName);
            } else {
                //Restore old file name
                $produit->setImage($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_edit', array('id' => $produit->getId()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("/delete/{id}", name="produit_deleteu")
     */
    public function deleteuAction(Request $request,Produit $produit)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $queryx = $qb->delete('CatalogueBundle:Produit', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $queryx->execute();
        return $this->redirectToRoute('produit_index');
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("/{id}", name="produit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/foo/chart", name="produit_chart")
     * @Method({"GET", "POST"})
     */
    public function chartAction()
    {
        $pieChart = new PieChart();
        $em = $this->getDoctrine()->getManager();
        $queryx = $em->createQuery("SELECT p.nom ,p.views FROM CatalogueBundle:Produit p ");
        $views = $queryx->getResult();


        $pieChart->getData()->setArrayToDataTable($views,'nom','views');
        $pieChart->getOptions()->setTitle('My Daily Activities');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        return $this->render('produit/chart.html.twig', array(
            'piechart' => $pieChart,
        ));
    }




}
