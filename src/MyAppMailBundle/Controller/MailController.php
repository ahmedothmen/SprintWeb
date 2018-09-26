<?php

namespace MyAppMailBundle\Controller;

use MyAppMailBundle\Form\MailType;
use MyAppMailBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{


    public function indexAction(request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        // $em1=$this->getDoctrine()->getManager();
        $user=$em->getRepository('MyAppUserBundle:User')->find($reclamation->getIdUser());
        $reclamation->setEtat(1);
        $em->persist($reclamation);
        $em->flush();

        $mail = new Mail();
        // $em->flush();
            $message = \Swift_Message::newInstance()
            ->setSubject('Accusé de réception')
            ->setFrom('espritplus2016@gmail.com')
            ->setTo($user->getEmail())
            ->setBody( $this->renderView('MyAppMailBundle::email.html.twig', array( 'prenom'=>$user->getPrenom(),'nom'=>$user->getNom()) ), 'text/html' );
            $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('my_app_mail_accuse'));
    }

    public function successAction()
    {
        //return new Response("email envoyé avec succès, Merci de vérifier votre adresse mail."); }
        return $this->redirectToRoute("admin_affichage");
    }
}
