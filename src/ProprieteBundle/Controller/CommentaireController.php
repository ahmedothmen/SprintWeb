<?php

namespace ProprieteBundle\Controller;

use ProprieteBundle\Entity\Commentairepropriete;
use ProprieteBundle\Entity\Favorispropriete;
use ProprieteBundle\Entity\Propriete;
use ProprieteBundle\Form\CommentaireproprieteType;
use ProprieteBundle\Form\FavorisproprieteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class CommentaireController extends Controller
{

    function addAction(Request $request, Propriete $propriete)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaireprop = new Commentairepropriete();
        $userP = $em->getRepository('MyAppUserBundle:User')->findOneBy(array('id' => $propriete->getIdU()));
        $idP = $propriete->getIdP();
        $em = $this->getDoctrine()->getManager();
        $nbrC=$em->getRepository('ProprieteBundle:Commentairepropriete')->listCommentaireByProp($idP);
        $rating=$em->getRepository('ProprieteBundle:Commentairepropriete')->AVGRating($idP);

        $img=$em->getRepository('ProprieteBundle:Imagepropriete')->findOneBy(array('idP' => $propriete->getIdP()));
       // $url=$img->getUrl();


        $query = $em->createQuery(
            'SELECT c FROM ProprieteBundle:Commentairepropriete c where (c.idP = :propriete)'
        )->setParameter('propriete', $idP);

        $commentaires = $query->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        $form = $this->createForm(CommentaireproprieteType::class, $commentaireprop);
        $form->handleRequest($request);
        $user = $this->getUser();
        $id = $user->getId();

        $favorisProp=$em->getRepository('ProprieteBundle:Favorispropriete')->findOneBy(array('idu'=>$id,'idp'=>$idP));

        if ($form->isSubmitted()) {
            $commentaireprop->setIdU($id);
            $commentaireprop->setIdP($propriete->getIdP());
            $commentaireprop->setDate(new \DateTime('now'));
            $em->persist($commentaireprop);
            $em->flush();
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("Votre Commentaire a été ajouté avec succés");

            return $this->redirectToRoute("propriete_showAll");
        }

        return $this->render("ProprieteBundle:Commentaire:comment.html.twig", array("form" => $form->createView(),
            'propriete' => $propriete,
            'commentaires' => $commentaires,
            'nom' => $userP->getUsername(),
            'id' => $id,
            'idP'=>$idP,
          //  'url'=>$url,
            'userP'=>$userP,
            'pagination' => $pagination,
            'nbrC'=>$nbrC,
            'rating'=>$rating,
            'img'=>$img,
            'favorisProp'=>$favorisProp
        ));
    }

    function modifierAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('ProprieteBundle:Commentairepropriete')->findOneById($id);
        $form = $this->createForm(CommentaireproprieteType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            $this->addFlash(
                'notice',
                'Avis modifié avec succée'
            );

            return $this->redirectToRoute("propriete_comment");
        }
        return $this->render("ProprieteBundle:Commentaire:edit.html.twig", array("form" => $form->createView()));

    }

    function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $evaluation = $em->getRepository('ProprieteBundle:Commentairepropriete')->findOneById($id);
        $em->remove($evaluation);
        $em->flush();
        $this->addFlash(
            'notice',
            'Avis supprimé avec succée'
        );
        return $this->redirectToRoute("propriete_comment");
    }

    public function afficherBackAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('ProprieteBundle:Commentairepropriete')->findAll(); /*fct findAll*/
        return $this->render("ProprieteBundle:Commentaire:afficherBack.html.twig", array('commentaires' => $commentaires));
    }

    public function supprimerBackAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('ProprieteBundle:Commentairepropriete')->findOneById($id);
        $em->remove($commentaire);
        $em->flush();
        $this->addFlash(
            'notice',
            'Commentaire supprimé avec succée'
        );
        return $this->redirectToRoute("propriete_commentAfficher_back");
    }

    public function getPropAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();
            $id = $user->getId();
        }
        $query = $em->createQuery(
            'SELECT p
            FROM ProprieteBundle:Propriete p
            where (p.idU = :identifier)'
        )->setParameter('identifier', $id);
        $proprietes = $query->getResult();
        return $this->render('ProprieteBundle:Propriete:getPropByUser.html.twig', array(
            'proprietes' => $proprietes,

        ));
    }

    public function ajouterFavorisAction(Request $request, Propriete $propriete)
    {
        $em = $this->getDoctrine()->getManager();

        $favoris = new Favorispropriete();
        $user = $this->getUser();
        $id = $user->getId();
        if ($request->isMethod("POST")) {
            $favoris->setIdU($id);
            $favoris->setIdP($propriete->getIdP());
            $em->persist($favoris);
            $em->flush();
            $this->get('ras_flash_alert.alert_reporter')->addSuccess("La propriete a été ajoutée a votre liste de favoris");

            return $this->redirectToRoute("propriete_showAll");
        }

        return $this->render("propriete_showAll");
    }
    public function supprimerFavorisAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $favorisPropriete = $em->getRepository('ProprieteBundle:Favorispropriete')->findOneById($id);
        $em->remove($favorisPropriete);
        $em->flush();
        $this->addFlash(
            'notice',
            'Propriete favoris supprimé avec succée'
        );
        $this->get('ras_flash_alert.alert_reporter')->addSuccess("La propriete a été supprimée a votre liste de favoris");

        return $this->redirectToRoute("propriete_showAll");
    }
    public function afficherFavorisAction()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $propriete = $em->getRepository('ProprieteBundle:Favorispropriete')->afficherPropFavoris($id);

        return $this->render("ProprieteBundle:Propriete:afficherFavoris.html.twig", array('proprietes' => $propriete));
    }

}
