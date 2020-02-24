<?php

namespace ReparationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ReparationBundle:Default:index.html.twig');
    }
}
