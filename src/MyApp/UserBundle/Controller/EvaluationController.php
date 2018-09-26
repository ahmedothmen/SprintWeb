<?php

namespace MyApp\UserBundle\Controller;

use MyApp\UserBundle\Entity\Evaluation;
use MyApp\UserBundle\Form\EvaluationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\HttpFoundation\Session\Session;



class EvaluationController extends Controller
{

    public function evaluationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evaluations=$em->getRepository('MyAppUserBundle:Evaluation')->findBy([
            'idE' => $this->get('session')->get('idExxp')
        ]);
        $moy=$em->getRepository('MyAppUserBundle:Evaluation')->AVGrating($this->get('session')->get('idExxp'));
        $voteExist = $em->getRepository('MyAppUserBundle:Evaluation')->findOneBy([
            'user' => $this->getUser(),
            'idE' => $evaluations
        ]);
        $Evaluation= new Evaluation();
        $id=$this->getUser()->getId();
        $form=$this->createForm(EvaluationType::class,$Evaluation);
        $form->handleRequest($request);

        $evaluations=$this->get('knp_paginator')->paginate(
            $evaluations,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        if(!$voteExist) {
            if($form->isValid())
            {
                $Evaluation->setUser($this->getUser());
                $Evaluation->setDate(new \DateTime('now'));
                $Evaluation->setTime(new \DateTime('now'));
                $Evaluation->setIdE($this->get('session')->get('idExxp'));
                $em->persist($Evaluation);
                $em->flush();
                $evaluations=$em->getRepository('MyAppUserBundle:Evaluation')
                                ->findBy([
                                    'idE' => $this->get('session')->get('idExxp')
                                ]); /*fct findAll*/
                $evaluations=$this->get('knp_paginator')
                                  ->paginate($evaluations,
                                             $request->query
                                                     ->getInt('page', 1)/*page number*/,
                                                                      5/*limit per page*/
                                  );
                $this->addFlash('notice', 'Avis ajouté avec succée');
                return $this->render(':Evaluation:ajout.html.twig',array(
                    'form'=>$form->createView(),'evaluations'=>$evaluations,'id'=>$id,'moy'=>$moy
                    )
                );
            }
        } else {
            $em->flush();
            $this->addFlash('alert', 'Vous avez déja donné votre avis !');
            return $this->render(':Evaluation:ajout.html.twig',array(
                    'form'=>$form->createView(),
                    'evaluations'=>$evaluations,
                    'id'=>$id,
                    'moy'=>$moy
                )
            );
        }
        return $this->render(':Evaluation:ajout.html.twig',array(
                'form'=>$form->createView(),
                'evaluations'=>$evaluations,
                'id'=>$id,
                'moy'=>$moy
            )
        );
    }

    function afficherAction(){
        $em=$this->getDoctrine()->getManager();
        $evaluations=$em->getRepository('MyAppUserBundle:Evaluation')->findAll(); /*fct findAll*/
        return $this->render(":Evaluation:afficher.html.twig",array('evaluations'=>$evaluations));
    }


    function supprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $evaluation=$em->getRepository('MyAppUserBundle:Evaluation')->findOneById($id);
        $em->remove($evaluation);
        $em->flush();
        $this->addFlash(
            'notice',
            'Avis supprimé avec succée'
        );
        return $this->redirectToRoute("avis_ajouter");
    }

    function modifierAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $evaluation=$em->getRepository('MyAppUserBundle:Evaluation')->findOneById($id);
        $form=$this->createForm(EvaluationType::class,$evaluation);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($evaluation);
            $em->flush();
            $this->addFlash(
                'notice',
                'Avis modifié avec succée'
            );

            return $this->redirectToRoute("avis_ajouter");
        }
        return $this->render(":Evaluation:modifier.html.twig",array("form"=>$form->createView()));
    }

    function afficherBackAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $evaluations=$em->getRepository('MyAppUserBundle:Evaluation')->findAll(); /*fct findAll*/
        $moy=$em->getRepository('MyAppUserBundle:Evaluation')->AVGrating();

        $evaluations=$this->get('knp_paginator')->paginate(
                     $evaluations,
                     $request->query->getInt('page', 1)/*page number*/,
                                                     5/*limit per page*/
                                                          );
        return $this->render(':Evaluation/BackEnd:avis.html.twig',array(
                'evaluations'=>$evaluations,
                'moy'=>$moy
            )
        );
    }

    function supprimerBackAction($id)
    {
        $em=$this->getDoctrine()
                 ->getManager();
        $evaluation=$em->getRepository('MyAppUserBundle:Evaluation')
                       ->findOneById($id);
        $em->remove($evaluation);
        $em->flush();
        $this->addFlash('notice', 'Avis supprimé avec succée');
        return $this->redirectToRoute("avis_ajouter_back");
    }
}