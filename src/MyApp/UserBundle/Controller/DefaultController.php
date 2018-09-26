<?php

namespace MyApp\UserBundle\Controller;

use MyApp\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MyApp\UserBundle\Form\ImageuserType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $message="";
        return $this->render('MyAppUserBundle:Default:index.html.twig',array('message'=>$message));
    }
    public function indexBAction()
    {
        return $this->render('MyAppUserBundle:Default:indexB.html.twig');
    }

    public function testAction()
    {
        return $this->render('@FOSUser/test.html.twig');
    }

    public function adminpageAction()
    {
        return $this->render('@FOSUser/admin.html.twig');
    }
    public function clientpageAction()
    {

        $message="";
        return $this->render('MyAppUserBundle:Default:index.html.twig',array('message'=>$message));
    }

    public function expAction()
    {

        $em = $this->getDoctrine()->getManager();
        $moy=$em->getRepository('MyAppUserBundle:Evaluation')->AVGrating();
        return $this->render('::experience.html.twig',array('moy'=>$moy));
    }

    public function connectAction(Request $request)
    {


        return $this->render('connect.html.twig');
    }

    public function ajouterImageAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('MyAppUserBundle:User')->findOneById(32);
        $form =$this->createForm('MyApp\UserBundle\Form\ImageuserType',$user);
        $form->handleRequest($request);



        if ($form->isSubmitted() ) {

            $file = $user->getImgurl();
            $filename = $file->getClientOriginalName();


            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('image_directory'), $filename
            );
            $user->setImgurl($filename);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("my_app_user_homepage");


        }

        return $this->render('MyAppUserBundle:Registration:confirmed.html.twig', array(

            'form' => $form->createView(),
        ));

    }




}
