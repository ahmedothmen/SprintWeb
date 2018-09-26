<?php

namespace ProprieteBundle\Controller;

use ProprieteBundle\Entity\Commentairepropriete;
use ProprieteBundle\Entity\FavorisPropriete;
use ProprieteBundle\Entity\Propriete;
use ProprieteBundle\Form\FavorisproprieteType;
use ProprieteBundle\Form\ProprieteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class ProprieteController extends Controller
{

    public function showAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em  = $this->getDoctrine()->getManager();
        $dql   = "SELECT p FROM ProprieteBundle:Propriete p";

        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        $nbrP=$em->getRepository('ProprieteBundle:Propriete')->listPropriete();



        $proprietes = $em->getRepository('ProprieteBundle:Propriete')->findAll();
        $commentaires=$em->getRepository('ProprieteBundle:Commentairepropriete')->findAll();
        foreach($proprietes as $pro){
            $img=$em->getRepository('ProprieteBundle:Imagepropriete')->findOneBy(array('idP'=>$pro->getIdP()));


            }
        return $this->render('ProprieteBundle:Propriete:showAll.html.twig', array(
            'proprietes' => $proprietes,
            'commentaires'=>$commentaires,
            'pagination' => $pagination,
            'nbrP'=>$nbrP,
            'img'=>$img
        ));
    }
    public function proprieteTriDescAction(Request $request)
{
    $em = $this->getDoctrine()->getManager();

    $em  = $this->getDoctrine()->getManager();

    $nbrP=$em->getRepository('ProprieteBundle:Propriete')->listPropriete();



    $proprietes = $em->getRepository('ProprieteBundle:Propriete')->listProprieteByPrixD();
    $commentaires=$em->getRepository('ProprieteBundle:Commentairepropriete')->findAll();
    return $this->render('ProprieteBundle:Propriete:ProprieteDesc.html.twig', array(
        'proprietes' => $proprietes,
        'commentaires'=>$commentaires,
        'nbrP'=>$nbrP
    ));
}
    public function proprieteTriAscAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em  = $this->getDoctrine()->getManager();

        $nbrP=$em->getRepository('ProprieteBundle:Propriete')->listPropriete();



        $proprietes = $em->getRepository('ProprieteBundle:Propriete')->listProprieteByPrixA();
        $commentaires=$em->getRepository('ProprieteBundle:Commentairepropriete')->findAll();
        return $this->render('ProprieteBundle:Propriete:ProprieteDesc.html.twig', array(
            'proprietes' => $proprietes,
            'commentaires'=>$commentaires,
            'nbrP'=>$nbrP
        ));
    }
    public function proprieteTriRatingAscAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em  = $this->getDoctrine()->getManager();

        $nbrP=$em->getRepository('ProprieteBundle:Propriete')->listPropriete();



        $proprietes = $em->getRepository('ProprieteBundle:Propriete')->listProprieteByRatingAsc();
        $commentaires=$em->getRepository('ProprieteBundle:Commentairepropriete')->findAll();
        return $this->render('ProprieteBundle:Propriete:ProprieteDesc.html.twig', array(
            'proprietes' => $proprietes,
            'commentaires'=>$commentaires,
            'nbrP'=>$nbrP
        ));
    }
    public function proprieteTriRatingDescAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em  = $this->getDoctrine()->getManager();

        $nbrP=$em->getRepository('ProprieteBundle:Propriete')->listPropriete();



        $proprietes = $em->getRepository('ProprieteBundle:Propriete')->listProprieteByRatingDesc();
        $commentaires=$em->getRepository('ProprieteBundle:Commentairepropriete')->findAll();
        return $this->render('ProprieteBundle:Propriete:ProprieteDesc.html.twig', array(
            'proprietes' => $proprietes,
            'commentaires'=>$commentaires,
            'nbrP'=>$nbrP
        ));
    }


    public function newAction(Request $request)
    {
        $propriete = new Propriete();
        $user = $this->getUser();
        $id = $user->getId();
        if ($request->isMethod("POST")) {
            $catprop = $request->get('catprop');
            $typeprop = $request->get('typeprop');
            $pays = $request->get('pays');
            $ville = $request->get('ville');
            $rue = $request->get('rue');
            $titre = $request->get('titre');
            $prix = $request->get('prix');
            $nbrchambre = $request->get('nbrchambre');
            $nbrvoyageur = $request->get('nbrvoyageur');
            $description = $request->get('description');
            if ($request->get('annimaux') == 'annimauxoui')
                $annimaux = true;
            else
                $annimaux = false;
            if ($request->get('fumeur') == 'fumeuroui')
                $fumeur = true;
            else
                $fumeur = false;
            if ($request->get('alcool') == 'alcooloui')
                $alcool = true;
            else
                $alcool = false;
            if ($request->get('enfant') == 'enfantoui')
                $enfant = true;
            else
                $enfant = false;


            $propriete->setCategoriepropriete($catprop);
            $propriete->setTypepropriete($typeprop);
            $propriete->setPays($pays);
            $propriete->setVille($ville);
            $propriete->setRue($rue);
            $propriete->setTitre($titre);
            $propriete->setPrix($prix);
            $propriete->setNbrchambre($nbrchambre);
            $propriete->setNbrvoyageur($nbrvoyageur);
            $propriete->setDescription($description);
            $propriete->setAnimaux($annimaux);
            $propriete->setFumeur($fumeur);
            $propriete->setAlcool($alcool);
            $propriete->setEnfant($enfant);
            $propriete->setIdU($id);

            $em = $this->getDoctrine()->getManager();
            $em->persist($propriete);
            $em->flush();

            $this->get('ras_flash_alert.alert_reporter')->addSuccess("Votre proprietes a été ajoutée avec succés, En cas de reservation nous allons vous communiquer");
            return $this->redirectToRoute('propriete_showAll');
        }
        return $this->render('ProprieteBundle:Propriete:new.html.twig');

    }

    public function showAction(Propriete $propriete)
    {



        return $this->render('ProprieteBundle:Propriete:comment.html.twig',array(
            'propriete'=>$propriete));
    }
    public function editAction(Request $request)
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $propriete=$em->getRepository("ProprieteBundle:Propriete")->findOneByIdP($id);


        $editForm=$this->createForm(ProprieteType::class, $propriete);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($propriete);
            $em->flush();
            //  $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('propriete_showAll');
        }
        return $this->render("ProprieteBundle:Propriete:edit.html.twig",array(

            'edit_form'=>$editForm->createView()
        ));
    }
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $propriete=$em->getRepository("ProprieteBundle:Propriete")->findOneByIdP($id);
        $em->remove($propriete);
        $em->flush();
        /* $form = $this->createDeleteForm($propriete);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->remove($propriete);
             $em->flush();
         }*/

        return $this->redirectToRoute('propriete_showAll');
    }
    private function createDeleteForm(Propriete $propriete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('propriete_delete', array('id' => $propriete->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function getPropAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();
            $id = $user->getId();
        }
        $nbrP=$em->getRepository('ProprieteBundle:Propriete')->listProprieteByUser($id);
        $query = $em->createQuery(
            'SELECT p
            FROM ProprieteBundle:Propriete p
            where (p.idU = :identifier)'
        )->setParameter('identifier', $id);
        $proprietes = $query->getResult();
        return $this->render('ProprieteBundle:Propriete:getPropByUser.html.twig', array(
            'proprietes' => $proprietes,
            'nbrP'=>$nbrP

        ));
    }
    public function afficherBackAction()
    {
        $em=$this->getDoctrine()->getManager();
        $proprietes=$em->getRepository('ProprieteBundle:Propriete')->findAll(); /*fct findAll*/
        return $this->render("ProprieteBundle:Propriete:afficherBack.html.twig",array('proprietes'=>$proprietes));
    }
    public function supprimerBackAction($id){
        $em=$this->getDoctrine()->getManager();
        $proprietes=$em->getRepository('ProprieteBundle:Propriete')->findOneByIdP($id);
        $em->remove($proprietes);
        $em->flush();
        $this->addFlash(
            'notice',
            'Propriete supprimé avec succée'
        );
        return $this->redirectToRoute("propriete_afficher_back");
    }


}
