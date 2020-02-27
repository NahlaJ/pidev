<?php

namespace ArticleBundle\Controller;

use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\Commentaire;
use ArticleBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use \Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{
    public function addAction(Request $request, UserInterface $user)
    {



        $article = new Article();
        $form= $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $file = $article->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $article->setPhoto($filename);
            //$article->setCreator($this->getUser());
            $article->setDate(new \DateTime('now'));

            $article->setUser($user);

            $em->persist($article);
            $em->flush();

            $this->addFlash('info', 'Created Successfully !');
        }
        return $this->render('@Article/Article/add.html.twig', array(
            "Form"=> $form->createView()
        ));
    }
    public function adduAction(Request $request ,UserInterface $user)
    {

        $article = new Article();
        $form= $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $file = $article->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $article->setPhoto($filename);
            //$article->setCreator($this->getUser());
            $article->setDate(new \DateTime('now'));
            $article->setEtat(0);
            $article->setUser($user);

            $em->persist($article);
            $em->flush();

            $this->addFlash('info', 'Created Successfully !');
        }
        return $this->render('@Article/Article/addu.html.twig', array(
            "Form"=> $form->createView()
        ));
    }

    public function listeAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->confirmedArticle();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $articles=$paginator->paginate(
          $articles,
          $request->query->getInt('page',1),
          $request->query->getInt('limit',3)
        );


        return $this->render("@Article/Article/liste.html.twig", array(
            "articles" =>$articles
        ));

    }
    public function listeuAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $articles=$paginator->paginate(
            $articles,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );

        return $this->render("@Article/Article/listeu.html.twig", array(
            "articles" =>$articles
        ));

    }
    public function updateAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $p= $em->getRepository('ArticleBundle:Article')->find($id);
        $form=$this->createForm(ArticleType::class,$p);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $file = $p->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $p->setPhoto($filename);
            $p->setDate(new \DateTime('now'));
            $em= $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('liste');

        }
        return $this->render('@Article/Article/update.html.twig', array(
            "form"=> $form->createView()
        ));
    }
    public function updateuAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository('ArticleBundle:Article')->find($id);
        $form = $this->createForm(ArticleType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $file = $p->getPhoto();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $p->setPhoto($filename);
            $p->setDate(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirectToRoute('listeu');

        }
        return $this->render('@Article/Article/updateu.html.twig', array(
            "form" => $form->createView()
        ));
    }
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $Article=$em->getRepository('ArticleBundle:Article')->find($id);
        $em->remove($Article);
        $em->flush();
        return $this->redirectToRoute('liste');
    }
    public function deleteuAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $Article=$em->getRepository('ArticleBundle:Article')->find($id);
        $em->remove($Article);
        $em->flush();
        return $this->redirectToRoute('listeu');
    }
    public function detailedAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $p=$em->getRepository('ArticleBundle:Article')->find($id);
        return $this->render('@Article/Article/detailed.html.twig', array(
            'titre'=>$p->getTitre(),
            'date'=>$p->getDate(),
            'photo'=>$p->getPhoto(),
            'descripion'=>$p->getDescription(),
            'articles'=>$p,
            'commentaires'=>$p,
            'id'=>$p->getId()
        ));
    }
    public function detaileduAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $p=$em->getRepository('ArticleBundle:Article')->find($id);
        return $this->render('@Article/Article/detailedu.html.twig', array(
            'titre'=>$p->getTitre(),
            'date'=>$p->getDate(),
            'photo'=>$p->getPhoto(),
            'descripion'=>$p->getDescription(),
            'articles'=>$p,
            'commentaires'=>$p,
            'id'=>$p->getId()
        ));
    }
    public function addCommentAction(Request $request, UserInterface $user, Article $article)
    {

        $ref = $request->headers->get('referer');
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($article->getId());


        $commentaire = new Commentaire();
        $commentaire->setDate(new \DateTime('now'));
        $commentaire->setTexte($request->request->get('comment'));
        $commentaire->setArticle($article);
        $commentaire->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);
        $em->flush();

        $this->addFlash(
            'info', 'Comment published !.'
        );

        return $this->redirect($ref);

    }
public function deleteCommentAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $commentaire=$em->getRepository(Commentaire::class)->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('liste');
    }

public function deleteuCommentAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $commentaire=$em->getRepository(Commentaire::class)->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('listeu');
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $articles =  $em->getRepository('ArticleBundle:Article')->findEntitiesByString($requestString);
        if(!$articles) {
            $result['articles']['error'] = "Post Not found :( ";
        } else {
            $result['articles'] = $this->getRealEntities($articles);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($articles){
        foreach ($articles as $articles){
            $realEntities[$articles->getId()] = [$articles->getPhoto(),$articles->getTitre()];

        }
        return $realEntities;
    }

    public function accepterAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $article=$em->getRepository('ArticleBundle:Article')->find($id);

        $article->setEtat(0);
        $em->flush();

        return $this->redirectToRoute('listeu');
    }

    public function listemAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('ArticleBundle:Article')->confirmedArticle();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $articles=$paginator->paginate(
            $articles,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );


        return $this->render("@Article/Article/mes.html.twig", array(
            "articles" =>$articles
        ));

    }

}

