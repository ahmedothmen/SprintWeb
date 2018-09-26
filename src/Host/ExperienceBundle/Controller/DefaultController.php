<?php

namespace Host\ExperienceBundle\Controller;

use Host\ExperienceBundle\Entity\Experience;
use Host\ExperienceBundle\Form\ExperienceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HostExperienceBundle:experience:index.html.twig');
    }

}
