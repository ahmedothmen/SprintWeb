<?php

namespace evaluationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use evaluationBundle\Entity\evaluation;

use Symfony\Component\HttpFoundation\Request;
class evaluationController extends Controller
{
    public function newAction(Request $request)
    {

        $evaluations=new evaluation();


        if($request->isMethod("POST"))
        {
//
            //var_dump($request->get('field_subject'));die;
            $type_d_acceuil=$request->get('field_subject');
            $etat_chambre=$request->get('field_subject1');
            $caractere_du_host=$request->get('field_subject2');
            $reglement=$request->get('field_subject3');
            $qualite_prix=$request->get('field_subject4');
            $experience_globale=$request->get('field_subject5');


            $evaluations->setTypeDAcceuil($type_d_acceuil);
            $evaluations->setEtatChambre($etat_chambre);
            $evaluations->setCaractereDuHost($caractere_du_host);
            $evaluations->setReglement($reglement);
            $evaluations->setQualitePrix($qualite_prix);
            $evaluations->setExperienceGlobale($experience_globale);

            $em = $this->getDoctrine()->getManager();
            $em->persist($evaluations);
            $em->flush();
        }
        return $this->render('evaluationBundle:Default:index.html.twig');
        //  }

        //   'form' => $form->createView(),

    }


}
