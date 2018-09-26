<?php

namespace ProprieteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProprieteBundle:Default:index.html.twig');
    }
}
