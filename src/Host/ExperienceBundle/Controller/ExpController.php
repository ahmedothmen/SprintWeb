<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/03/2017
 * Time: 18:57
 */

namespace Host\ExperienceBundle\Controller;


use Host\ExperienceBundle\Entity\Experience;
use Host\ExperienceBundle\Form\ExperienceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ExpController extends Controller
{
    public function profileAction()
    {
        return $this->render('HostExperienceBundle:experience:profile.html.twig');
    }


    public function addAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser();

        $exp = new Experience();
        $em=$this->getDoctrine()->getManager();


        $form = $this->createForm(ExperienceType::class,$exp );
        $form->handleRequest($request);

        if($form->isSubmitted() ) {

            $exp->setIdUser($id);
            $em->persist( $exp);
            $em->flush();
        }

        return $this->render('HostExperienceBundle:experience:add_exp.html.twig',array(
            'form'=>$form->createView(),



        ));




    }


    public function show_expAction () {
        $user = $this->getUser();
        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser();

        $em=$this->getDoctrine()->getManager();

        $exp = $em->getRepository('HostExperienceBundle:Experience')->findBy(array('id_user' => $id));



        return $this->render('HostExperienceBundle:experience:show_exp.html.twig',array(
            'Experience'=>$exp,


        ));
    }


    public function edit_expAction(Request $request,$idd)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser();


        $em=$this->getDoctrine()->getManager();

        $exp = $em->getRepository('HostExperienceBundle:Experience')->findOneBy(array('id_xp' => $idd ));
        $form = $this->createForm(ExperienceType::class,$exp );


        $form->handleRequest($request);

        if($form->isSubmitted() ) {

            $em->persist($exp);
            $em->flush();
            return $this->redirect($this->generateUrl('show_exp',array('msg'=>"Edit successful")));
        }
        return $this->render('HostExperienceBundle:experience:edit_exp.html.twig',array(
            'form'=>$form->createView(),



        ));




    }
    public function delete_expAction($idd)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }



        $em=$this->getDoctrine()->getManager();
        $exp = $em->getRepository('HostExperienceBundle:Experience')->findOneBy(array('id_xp' => $idd ));

        $em->remove( $exp);
        $em->flush();

        return $this->redirect($this->generateUrl('show_exp',array('msg'=>"Delete successful")));





    }
    public function exp_listAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $croisiere=$em->getRepository("HostExperienceBundle:Experience")->findAll();
      /*  $dql="SELECT p FROM HostExperienceBundle:Experience p";
             $query=$em->createQuery($dql);
      */
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $result = $paginator->paginate(
            //$query,
            $croisiere, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 4)
        );

        return $this->render('@HostExperience/experience/list_exp.html.twig',array("Experience"=>$result));
    }


    public function detailsAction($idexp)
    {
        $em=$this->getDoctrine()->getManager();
        $exp = $em->getRepository('HostExperienceBundle:Experience')->findOneBy(array('id_xp' => $idexp ));
        $session = new Session();
        $session->set('idExxp',$idexp);
        return $this->render('HostExperienceBundle:experience:details.html.twig',array('ex'=>$exp));
    }
    public function sortalphAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $croisiere=$em->getRepository("HostExperienceBundle:Experience")->findby(array(),array('nom_xp'=>'ASC'));
        /*  $dql="SELECT p FROM HostExperienceBundle:Experience p";
               $query=$em->createQuery($dql);
        */
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $result = $paginator->paginate(
        //$query,
            $croisiere, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 4)
        );

        return $this->render('@HostExperience/experience/list_exp.html.twig',array("Experience"=>$result));
    }
    public function sortalprixAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $croisiere=$em->getRepository("HostExperienceBundle:Experience")->findby(array(),array('prix_xp'=>'ASC'));
        /*  $dql="SELECT p FROM HostExperienceBundle:Experience p";
               $query=$em->createQuery($dql);
        */
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $result = $paginator->paginate(
        //$query,
            $croisiere, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 4)
        );

        return $this->render('@HostExperience/experience/list_exp.html.twig',array("Experience"=>$result));
    }

}