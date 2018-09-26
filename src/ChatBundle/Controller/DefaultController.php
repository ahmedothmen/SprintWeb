<?php

namespace ChatBundle\Controller;

use MessageBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MyApp\UserBundle\Entity\User;
use belousovr\belousovChatBundle\Form\ChatType;
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        $actionUrl = $this->generateUrl(
            'belousov_chat_ajax_send_message'
        );

        $getMessageUrl = $this->generateUrl(
            'belousov_chat_ajax_get_message'
        );

        $chatForm = $this->createForm(ChatType::class, null, array('action' => $actionUrl));

        return $this->render('ChatBundle:Default:index.html.twig', array('chatForm' => $chatForm->createView(), 'users' => $users, 'getMessageUrl' => $getMessageUrl, 'currentUser' => $this->getUser()));
    }

    public function indexFAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();


        $actionUrl = $this->generateUrl(
            'belousov_chat_ajax_send_message'
        );

        $getMessageUrl = $this->generateUrl(
            'belousov_chat_ajax_get_message'
        );

        $chatForm = $this->createForm(ChatType::class, null, array('action' => $actionUrl));




        $i=0;
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $queryForListFavoris = $em->createQuery("select f from MessageBundle\Entity\Favoris f where f.idUser = $id");
        $favoris = $queryForListFavoris->getResult();

        foreach ($favoris as $favori){
            $userz[$i]=$favori->getIdFavoris();
            $i++;
        }

        $query = $em->createQuery(
            'SELECT u
            FROM MyAppUserBundle:User u
            where ( u.id in (?1) )')
            ->setParameter(1,$userz);
        $userz = $query->getResult();

        return $this->render('ChatBundle:Default:index2.html.twig', array('chatForm' => $chatForm->createView(), 'users' => $users, 'getMessageUrl' => $getMessageUrl, 'currentUser' => $this->getUser()
        ,'favoris' => $favoris, 'userz'=>$userz));
    }
}
