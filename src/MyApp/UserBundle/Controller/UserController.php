<?php
/**
 * Created by PhpStorm.
 * User: Oussaa
 * Date: 28/03/2017
 * Time: 01:47
 */

namespace MyApp\UserBundle\Controller;

use MessageBundle\Entity\Favoris;
use MyApp\UserBundle\Entity\User;
use MyApp\UserBundle\Form\UserrType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Form\Type\VichFileType;



class UserController extends Controller
{
    public function showAllAction (){

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('MyAppUserBundle:User')->findAll();

        return $this->render('MyAppUserBundle:Default:userList.html.twig', array(
            'users' => $users,
        ));
    }

    public function addToFavorisAction(){
        $favorite = new Favoris();

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        if (isset($_GET['action']))
        {
                $favorite->setIdUser($id);
                $favorite->setIdFavoris($_GET['idFavoris']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($favorite);
                $em->flush();

                return $this->redirectToRoute('favoris_show');
        }
        return $this->render('MyAppUserBundle:Default:userList.html.twig');
    }

    public function profileShowAction(Request $request){


        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MyAppUserBundle:User')->findOneBy(array('id'=>$id));

        $form = $this->createForm(UserrType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new  \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('my_app_pic_edit'));
        }


        return $this->render('MyAppUserBundle:Profile:showProfile.html.twig',array(
            'user'=>$user,
            'form' => $form->createView(),

        ));
    }

    public function picEditAction(Request $request){
        $user = new User();

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        $form = $this->createForm(UserrType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new  \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->render('MyAppUserBundle:Profile:showProfile.html.twig', array(
                'form' => $form->createView(),
                'user'=>$user,
            ));
        }

        return $this->render('MyAppUserBundle:Profile:showProfile.html.twig', array(
            'form' => $form->createView(),
            'user'=>$user,
        ));

    }


}