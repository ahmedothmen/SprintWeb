<?php

namespace evaluationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('evaluationBundle:Default:index.html.twig');
    }
}
