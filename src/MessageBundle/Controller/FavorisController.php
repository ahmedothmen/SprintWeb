<?php
/**
 * Created by PhpStorm.
 * User: Oussaa
 * Date: 28/03/2017
 * Time: 04:04
 */

namespace MessageBundle\Controller;
use MessageBundle\Entity\Favoris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FavorisController extends Controller
{
    public function showAction()
    {
        $i=0;

        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $queryForListFavoris = $em->createQuery("select f from MessageBundle\Entity\Favoris f where f.idUser = $id");
        $favoris = $queryForListFavoris->getResult();

        foreach ($favoris as $favori){
            $users[$i]=$favori->getIdFavoris();
            $i++;

        }

        $query = $em->createQuery(
            'SELECT u
            FROM MyAppUserBundle:User u
            where ( u.id in (?1) )')
        ->setParameter(1,$users);

        $userz = $query->getResult();

        return $this->render('MessageBundle:Favoris:show.html.twig', array(
            'favoris' => $favoris,
            'users'=>$userz
        ));
    }

    public function deleteAction(){
        $i=0;

        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $repository = $this->getDoctrine()->getRepository('MessageBundle:Favoris');
        $f = $repository->findOneBy(array('idUser'=>$id,'idFavoris'=>$_GET['idf']));

        $em->remove($f);
        $em->flush();

        $queryForListFavoris = $em->createQuery("select f from MessageBundle\Entity\Favoris f where f.idUser = $id");
        $favoris = $queryForListFavoris->getResult();

        foreach ($favoris as $favori){
            $users[$i]=$favori->getIdFavoris();
            $i++;
        }

        $query = $em->createQuery(
            'SELECT u
            FROM MyAppUserBundle:User u
            where ( u.id in (?1) )')
            ->setParameter(1,$users);

        $userz = $query->getResult();

        return $this->render('MessageBundle:Favoris:show.html.twig', array(
            'favoris' => $favoris,
            'users'=>$userz
        ));

    }

    public function showFAction()
    {
        $i=0;

        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $queryForListFavoris = $em->createQuery("select f from MessageBundle\Entity\Favoris f where f.idUser = $id");
        $favoris = $queryForListFavoris->getResult();

        foreach ($favoris as $favori){
            $users[$i]=$favori->getIdFavoris();
            $i++;

        }

        $query = $em->createQuery(
            'SELECT u
            FROM MyAppUserBundle:User u
            where ( u.id in (?1) )')
            ->setParameter(1,$users);

        $userz = $query->getResult();


        return $this->render('MessageBundle:Favoris:showFront.html.twig', array(
            'favoris' => $favoris,
            'users'=>$userz
        ));
    }

    public function deleteFAction(){
        $i=0;

        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $repository = $this->getDoctrine()->getRepository('MessageBundle:Favoris');
        $f = $repository->findOneBy(array('idUser'=>$id,'idFavoris'=>$_GET['idf']));

        $em->remove($f);
        $em->flush();

        $queryForListFavoris = $em->createQuery("select f from MessageBundle\Entity\Favoris f where f.idUser = $id");
        $favoris = $queryForListFavoris->getResult();

        foreach ($favoris as $favori){
            $users[$i]=$favori->getIdFavoris();
            $i++;
        }

        $query = $em->createQuery(
            'SELECT u
            FROM MyAppUserBundle:User u
            where ( u.id in (?1) )')
            ->setParameter(1,$users);

        $userz = $query->getResult();

        return $this->render('MessageBundle:Favoris:show.html.twig', array(
            'favoris' => $favoris,
            'users'=>$userz
        ));

    }

    public function addFAction(Request $request ){
        $fav = new Favoris();
        $message="";

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $repository = $this->getDoctrine()->getRepository('MessageBundle:Favoris');



            $f =$request->get('id');
            $fav->setIdUser($id);
            $fav->setIdFavoris($f);
            $em = $this->getDoctrine()->getManager();
            $em->persist($fav);
            $em->flush();

            return $this->redirectToRoute('favoris_showF');



       // return $this->render('MyAppUserBundle:Default:index.html.twig',array('message'=>$message));

    }



}