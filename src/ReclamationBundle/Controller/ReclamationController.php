<?php

namespace ReclamationBundle\Controller;

use DateTime;
use Doctrine\ORM\Mapping\Entity;

use MyApp\UserBundle\Entity\User;
use ReclamationBundle\Entity\Archive;
use ReclamationBundle\Entity\Reclamation;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Reclamation controller.
 *
 */
class ReclamationController extends Controller
{
    /**
     * Lists all reclamation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reclamations = $em->getRepository('ReclamationBundle:Reclamation')->findAll();

        return $this->render('reclamation/index.html.twig', array(
            'reclamations' => $reclamations,
        ));
    }

    /**
     * Creates a new reclamation entity.
     *
     */
    public function newAction(Request $request)
    {
        $reclamation = new Reclamation();
        $user=$this->getUser();



            if($request->isMethod("POST"))
            {
//                if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
//                    $user = $this->container->get('security.token_storage')->getToken()->getUser();
//                    $id = $user->getId();
//                }
                $contenu=$request->get('field_message');
                $type=$request->get('field_subject');
                $now=new DateTime();
                $now->format('Y-m-d h:i:s');


                $reclamation->setIdUser($user->getId());
                $reclamation->setNom($user->getNom());
                $reclamation->setEmail($user->getEmail());
                $reclamation->setPrenom($user->getPrenom());
                $reclamation->setIdP($request->get('id'));



                $reclamation->setDate($now);
                $reclamation->setContenu($contenu);
                $reclamation->setType($type);
                $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            }
            return $this->render('ReclamationBundle:reclamation:new.html.twig');
      //  }

         //   'form' => $form->createView(),

    }






    public function afficherbackAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository('ReclamationBundle:Reclamation')->findAll();

        $reclamations=$this->get('knp_paginator')->paginate(
            $reclamations,
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('ReclamationBundle:reclamation/admin:reclamation.html.twig', array(
            'reclamations' => $reclamations,

        ));
    }

    function supprimerBackAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamations=$em->getRepository('ReclamationBundle:Reclamation')->findOneById($id);
        $Archive = new Archive();

        $now=new DateTime();
        $now->format('Y-m-d h:i:s');
        $user=$this->getUser();
        $Archive->setIdUser($this->getUser());
        $Archive->setNom($reclamations->getNom());
        $Archive->setPrenom($user);
        $Archive->setDate($now);
        $Archive->setContenu($reclamations->getContenu());
        $Archive->setType($reclamations->getType());
        $em = $this->getDoctrine()->getManager();
        $em->persist( $Archive);
        $em->flush();
        $em->remove( $reclamations);
        $em->flush();
        return $this->redirectToRoute("admin_affichage");
    }
}
