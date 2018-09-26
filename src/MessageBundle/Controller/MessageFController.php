<?php

namespace MessageBundle\Controller;

use DateTime;
use MessageBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Message controller.
 *
 */
class MessageFController extends Controller
{

    private $router;

    /**
     * Lists all message entities.
     *
     */
    public function showAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('MessageBundle:Message')->findAll();

        return $this->render('MessageBundle:Message:showAll.html.twig', array(
            'messages' => $messages,
        ));
    }

    //Updates the IdMessageBase

    public function updateAction($idm, $base)
    {
            $repository = $this->getDoctrine()->getRepository('MessageBundle:Message');

            // query for a single product matching the given name and price
            $m = $repository->findOneBy(array('id'=>$idm));

            $em = $this->getDoctrine()->getManager();
            $message = $em->getRepository('MessageBundle:Message')->find($m);

            $message->setIdMessageBase($base);
            $em->flush();
    }

    /**
     * Creates a new message entity.
     *
     */
    public function showFav()
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
        return $userz;
    }

    public function detectSpam($message)
    {
        $words=array('ads','sex', 'amour');
        $string = $message;
        foreach ($words as $word) {
            //if (strstr($string, $url)) { // mine version
            if (stripos($string, $word) !== FALSE) { // Yoshi version
                return true;
            }
        }
        return false;
    }

    public function newFAction(Request $request)
    {

        $list = $this->showFav();
        $message = new Message();

        $now = new DateTime();
        $now->format('Y-m-d');

        $time = new DateTime();
        $time ->format("H:i:s");


        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
            $np = $user->getPrenom()." ".$user->getNom();
        }

        $repository = $this->getDoctrine()->getRepository('MyAppUserBundle:User');
        $recepteur = $repository->findOneBy(array('id'=>$request->get('id')));


        $message->setTime($time);
        $message->setIdE($id);
        $message->setNp($np);
        $message->setDossier("Inbox");
        $message->setDate($now);
        $message->setIsRead(0);
        $message->setIsResponse(0);

        if($request->isMethod("POST")) {
            $subject = $request->get('subject');
            $contenu = $request->get('contenu');
            $label = $request->get('label');
            $recep= $request->get('toWho');

            $message->setSubject($subject);
            $message->setContenu($contenu);
            if ($this->detectSpam($message->getContenu())){
                $message->setDossier('Spam');
            }

            $message->setLabel($label);
            $message->setIdR($recep);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->updateAction($message->getId(),$message->getId());

            return $this->redirectToRoute('message_byUserFI');
        }

        $em = $this->getDoctrine()->getManager();
        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();


        return $this->render('MessageBundle:Mfront:newFront.html.twig',array(
            'users'=>$list,
            'recepteur'=>$recepteur,
            'count'=>$count
        ));
    }


    public function new2Action(Request $request)
    {
        $list = $this->showFav();
        $idr = $request->get('id');
        $message = new Message();

        $now = new DateTime();
        $now->format('Y-m-d');

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
            $np = $user->getPrenom()." ".$user->getNom();
        }

        $message->setIdR($idr);
        $message->setIdE($id);
        $message->setNp($np);
        $message->setDossier("Inbox");
        $message->setDate($now);
        $message->setIsRead(0);
        $message->setIsResponse(0);

        if($request->isMethod("POST")) {
            $subject = $request->get('subject');
            $contenu = $request->get('contenu');
            $label = $request->get('label');

            $message->setSubject($subject);
            $message->setContenu($contenu);
            $message->setLabel($label);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->updateAction($message->getId(),$message->getId());
            return $this->redirectToRoute('message_byUser');

        }

        $repository = $this->getDoctrine()->getRepository('MyAppUserBundle:User');
        $recepteur = $repository->findOneBy(array('id'=>$request->get('id')));

        $em = $this->getDoctrine()->getManager();
        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();



        return $this->render('MessageBundle:Message:new.html.twig',array(
            'users'=>$list,
            'recepteur'=>$recepteur,
            'count'=>$count,
        ));
    }

    public function ReplyFAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('MessageBundle:Message');
        $m = $repository->findOneBy(array('id'=>$request->get('id')));
        $idUser2 = $m->getIdE();
        $message = new Message();

        $repository2 = $this->getDoctrine()->getRepository('MyAppUserBundle:User');
        $recepteur= $repository2->findOneBy(array('id'=>$idUser2));

        $now = new DateTime();
        $now->format('Y-m-d');

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
            $np = $user->getPrenom()." ".$user->getNom();
        }

        $message->setIdE($id);
        $message->setIdR($idUser2);
        $message->setNp($np);
        $message->setDossier("Inbox");
        $message->setDate($now);
        $message->setIsRead(0);
        $message->setIsResponse(1);
        $em = $this->getDoctrine()->getManager();

        if($request->isMethod("POST")) {
            $subject = $request->get('subject');
            $contenu = $request->get('contenu');
            $label = $request->get('label');
            $message->setIdMessageBase($request->get('id'));

            $message->setSubject($subject);
            $message->setContenu($contenu);
            $message->setLabel($label);


            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message_byUserFI');
        }
        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();
        $users = $this->showFav();

        return $this->render('MessageBundle:Mfront:newFront.html.twig',array(
            'count'=>$count,
            'users'=>$users,
            'recepteur'=>$recepteur,
        ));

        /*$form = $this->createForm('MessageBundle\Form\MessageType', $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush($message);

            return $this->redirectToRoute('message_show', array('id' => $message->getId()));
        }

        return $this->render('MessageBundle:Message:new.html.twig', array(
            'message' => $message,

            'form' => $form->createView(),
        ));*/
    }


    /**
     * Finds and displays a message entity.
     *
     */
    public function showFAction(Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $message->setIsRead("1");
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }
        $repository = $this->getDoctrine()->getRepository('MyAppUserBundle:User');
        $u = $repository->findOneBy(array('id'=>$message->getIdE()));


        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();

        return $this->render('MessageBundle:Mfront:showFront.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
            'count'=>$count,
            'user'=>$u

        ));
    }

    /**
     * Displays a form to edit an existing message entity.
     *
     */
    public function editAction(Request $request, Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm('MessageBundle\Form\MessageType', $message);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_edit', array('id' => $message->getId()));
        }

        return $this->render('MessageBundle:Message:edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a message entity.
     *
     */
    public function deleteAction(Request $request, Message $message)
    {
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('message_showAll');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param Message $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Message $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }



    //msgDiscussion.html
    public function msgDiscussionFAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }
        $repository = $this->getDoctrine()->getRepository('MessageBundle:Message');
        $m = $repository->findOneBy(array('id'=>$request->get('id')));
        $idUser2 = $m->getIdE();

        $query = $em->createQuery(
            'SELECT m
            FROM MessageBundle:Message m
            where ( m.idR in (?1,?2) and m.idE in (?3,?4) and m.idMessageBase=?5 ) '
        )->setParameter(1,$id);

        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();


        $query->setParameter(2,$idUser2);
        $query->setParameter(3,$idUser2);
        $query->setParameter(4,$id);
        $query->setParameter(5,$request->get('id'));

        $messages = $query->getResult();

        return $this->render('MessageBundle:Mfront:msgDiscussionF.html.twig',array(
        'messages' => $messages,
            'count'=>$count));
    }

    public function moveToAction(){

        if (isset($_GET['action']))
            {
                $repository = $this->getDoctrine()->getRepository('MessageBundle:Message');

                // query for a single message
                $m = $repository->findOneBy(array('id'=>$_GET['id']));


                    $em = $this->getDoctrine()->getManager();
                    $message = $em->getRepository('MessageBundle:Message')->find($m);
                    $message->setDossier($_GET['action']);

                    $em->flush();

                $query = $em->createQuery(
                    'SELECT m
            FROM MessageBundle:Message m
            where (m.idMessageBase = :identifier )'
                )->setParameter('identifier', $message->getIdMessageBase());

                $messages = $query->getResult();

                foreach ($messages as $msg){
                    $msg->setDossier($message->getDossier());
                    $em->flush();
                }
            }

        /*
        if ($request->isXmlHttpRequest()) {
            $idMsg=$request->request->get('id');
            return new JsonResponse(array('status'=>'success'));
    }
    else return new JsonResponse(array('status'=>'failed'));*/
    }

    public function getMsgAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $query = $em->createQuery(
            'SELECT m
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isResponse=0 )'
        )->setParameter('identifier', $id);

        $messages = $query->getResult();

        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();

        /*if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $repository = $this->getDoctrine()->getRepository('MessageBundle:Message');
        $query = $repository->createQueryBuilder('m')
            ->where('m.idE = :identif' )
            ->setParameter('identif', $id)
            ->getQuery();

        $messages = $query->getResult();*/

        return $this->render('MessageBundle:Mfront:getForInboxFront.html.twig', array(
            'messages' => $messages,
            'count'=> $count,
        ));
    }

    public function getMsgFTAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $query = $em->createQuery(
            'SELECT m
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isResponse=0 )'
        )->setParameter('identifier', $id);

        $messages = $query->getResult();

        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();

         return $this->render('MessageBundle:Mfront:getForTrashFront.html.twig', array(
            'messages' => $messages,
            'count'=> $count,
        ));
    }

    public function getMsgFSAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $id = $user->getId();
        }

        $query = $em->createQuery(
            'SELECT m
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isResponse=0 )'
        )->setParameter('identifier', $id);

        $messages = $query->getResult();

        $query2 = $em->createQuery(
            'SELECT COUNT(m.idE)
            FROM MessageBundle:Message m
            where (m.idR = :identifier and m.isRead=0)'
        )->setParameter('identifier', $id);

        $count = $query2->getSingleScalarResult();

     return $this->render('MessageBundle:Mfront:getForSpamFront.html.twig', array(
        'messages' => $messages,
        'count'=> $count,
    ));
    }
}
