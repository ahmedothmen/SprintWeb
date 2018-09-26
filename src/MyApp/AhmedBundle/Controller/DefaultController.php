<?php

namespace MyApp\AhmedBundle\Controller;

use MyApp\AhmedBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;




class DefaultController extends Controller
{
    public function factureAction()
    {

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->Facture(88);

        return $this->render('MyAppAhmedBundle:Default:Facture.html.twig',array('proprietes'=>$pros));
    }

    public function affichageFactureAction(Request $request)
    {

        $id=(string) $request->get('id').'file.pdf';

        return $this->render('MyAppAhmedBundle:Default:AffichageFacture.html.twig',array('id'=>$id));
    }


    public function indexAction()
    {
        $nbre=null;

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->MostResevedDQL();


        return $this->render('MyAppAhmedBundle:Default:index.html.twig',array('proprietes'=>$pros ,'nbre'=>$nbre));
    }

    public function nbreReservationAction(Request $request)
    {
        $nbre=null;

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->findProprieteDQL();
        $nbre = $em->getRepository("MyAppAhmedBundle:Reservation")->nbreReservation($request->get('id'));

        return $this->render('MyAppAhmedBundle:Default:index.html.twig',array('proprietes'=>$pros ,'nbre'=>$nbre));
    }

    public function topDestAction()
    {



        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->MostResevedDQL();


        return $this->render('MyAppAhmedBundle:Default:TopDestination.html.twig',array('proprietes'=>$pros));
    }

    public function voirDetailAction(Request $request)
    {
        $message=null;

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->voirDetailDQL($request->get('id'));
        $nbre = $em->getRepository("MyAppAhmedBundle:Reservation")->nbreReservation($request->get('id'));
        return $this->render('MyAppAhmedBundle:Default:VoirDetaille.html.twig',array('proprietes'=>$pros ,'message'=>$message,'n'=>$nbre));
    }

    public function proprieteDisponibleAction(Request $request)
    {
        $message="";

        if ($request->get('arrival')<$request->get('departure')) {
            $session = new Session();
            $session->set('dateDebut', $request->get('arrival'));
            $session->set('dateFin', $request->get('departure'));
            //$user = $this->getUser()->getId();


            $message = "";
            if ($request->get('Categorie') != "Categorie" and ($request->get('ville') != "ville")) {


                $em = $this->getDoctrine()->getManager();
                $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->findProprieteByVilleAndCategorieDQL($request->get('ville'), $request->get('Categorie'));
                if ($pros != null) {

                    return $this->render('MyAppAhmedBundle:Default:ProprieteDisponible.html.twig', array('proprietes' => $pros));
                } else {
                    $message = "aucun chambre trouvee";
                    return $this->render('MyAppUserBundle:Default:index.html.twig', array('message' => $message));
                }


            } elseif ($request->get('Categorie') != "Categorie") {
                $em = $this->getDoctrine()->getManager();
                $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->findProprieteByCategorieDQL($request->get('Categorie'));


                if ($pros != null) {

                    return $this->render('MyAppAhmedBundle:Default:ProprieteDisponible.html.twig', array('proprietes' => $pros));
                } else {
                    $message = "aucun chambre trouvee";
                    return $this->render('MyAppUserBundle:Default:index.html.twig', array('message' => $message));
                }
            } elseif ($request->get('ville') != "ville") {
                $em = $this->getDoctrine()->getManager();
                $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->findProprieteByVilleDQL($request->get('ville'));


                if ($pros != null) {

                    return $this->render('MyAppAhmedBundle:Default:ProprieteDisponible.html.twig', array('proprietes' => $pros));
                } else {
                    $message = "aucun chambre trouvee";
                    return $this->render('MyAppUserBundle:Default:index.html.twig', array('message' => $message));
                }
            } elseif ($request->get('Categorie') == "Categorie" and ($request->get('ville') == "ville")) {


                $em = $this->getDoctrine()->getManager();
                $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->findProprieteDQL();


                return $this->render('MyAppAhmedBundle:Default:ProprieteDisponible.html.twig', array('proprietes' => $pros));
            }
        }
        else {
            $message = "date de depart doit etre superieur a la date d arrivee";
            return $this->render('MyAppUserBundle:Default:index.html.twig', array('message' => $message));
        }
    }
    public function reserverAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();

        if ( $this->getUser()==null){

            $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->voirDetailDQL($request->get('id'));

            $message = "svp! connecter pour reserver";
            $nbre = $em->getRepository("MyAppAhmedBundle:Reservation")->nbreReservation($request->get('id'));
            return $this->render('MyAppAhmedBundle:Default:VoirDetaille.html.twig',array('proprietes'=>$pros ,'message'=>$message,'n'=>$nbre));

        }

        if ( $pop1 = $em->getRepository("MyAppAhmedBundle:Reservation")->verifierAvantReserver($this->getUser()->getId(),$request->get('id'))){

            $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->voirDetailDQL($request->get('id'));

            $message = "vous avez deja un demande de reservation pour cette chmabre";
            $nbre = $em->getRepository("MyAppAhmedBundle:Reservation")->nbreReservation($request->get('id'));
            return $this->render('MyAppAhmedBundle:Default:VoirDetaille.html.twig',array('proprietes'=>$pros ,'message'=>$message,'n'=>$nbre));

        }
        else {
            $reservation = new Reservation();
            $reservation->setDateDebut($this->get('session')->get('dateDebut'));
            $reservation->setDateFin($this->get('session')->get('dateFin'));
            $reservation->setEtat("false");
            $pop = $em->getRepository('ProprieteBundle:Propriete')->findOneByIdP(array($request->get('id')));
            $reservation->setPropriete($pop->getIdP());
            $user=$em->getRepository('MyAppUserBundle:User')->findOneBy(array('id' => $pop->getIdU()));
            $reservation->setUser( $user);


            $reservation->setUserDemandant($this->getUser()->getId());
            $em = $this->getDoctrine()->getManager();


            $em->persist($reservation);


            $em->flush();
            $em = $this->getDoctrine()->getManager();
            $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->voirDetailDQL($request->get('id'));
            $message = "votre demande des reservations effectue avec success attendre notre confiramation dans 2 jours";
            $nbre = $em->getRepository("MyAppAhmedBundle:Reservation")->nbreReservation($request->get('id'));
            return $this->render('MyAppAhmedBundle:Default:VoirDetaille.html.twig', array('proprietes' => $pros, 'message' => $message,'n'=>$nbre));
        }
    }

    public function listDemandeRersevationAction()
    {
        $nb=null;
        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->findDemandeNonValider($this->getUser()->getId());

        return $this->render('MyAppAhmedBundle:Default:ListDemandeRservation.html.twig',array('proprietes'=>$pros));
    }

    public function validerDemandeAction(Request $request )
    {

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->find($request->get('id'));
        $pros->setEtat('true');
        $em->flush();
        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("ProprieteBundle:Propriete")->find($request->get('id_p'));
        $pros1 = $em->getRepository("MyAppAhmedBundle:Reservation")->facture($request->get('id'));


        $snappy = new Pdf('C://"Program Files"/wkhtmltopdf/bin/wkhtmltopdf.exe');
        $snappy->generateFromHtml(  $this->renderView(
            'MyAppAhmedBundle:Default:Facture.html.twig',
            array(
                'proprietes'=>$pros1
            )
        ),
            (string)$request->get('id').'file.pdf'
        );
        $this->getDoctrine()->getManager()->getRepository("MyAppAhmedBundle:Reservation")->deletDemande($request->get('id_p'));
        return $this->redirectToRoute("my_app_ahmed_Demande_Reservation");
    }

    function supprimerAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("MyAppAhmedBundle:Reservation")->findOneById($request->get('id'));
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute("my_app_ahmed_Demande_Reservation");
    }

    public function menuAction()
    {

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->listProprieteByDemande($this->getUser()->getId());
        return $this->render('MyAppAhmedBundle:Default:Menu.html.twig',array('proprietes'=>$pros));
    }

    public function listDemandeRersevationByProprieteAction(Request $request)
    {
        $nbre=null;

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->findDemandeNonValiderByIdPropriete($request->get('id'));


        return $this->render('MyAppAhmedBundle:Default:ListDemandeRservation.html.twig',array('proprietes'=>$pros));
    }

    public function menuDroitAction()
    {

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->NbreDeJourRestant($this->getUser()->getId());

        return $this->render('MyAppAhmedBundle:Default:MenuDroit.html.twig',array('proprietes'=>$pros));
    }


    public function listProprietByIdUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->ListProprieteByUser($this->getUser()->getId());


        return $this->render('MyAppAhmedBundle:Default:MenuResrvation.html.twig',array('proprietes'=>$pros));
    }
    public function ListReservationByProprieteAction()
    {

        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->ListProprieteByUser($this->getUser()->getId());
        $session->set('list', $pros);
        return $this->render('MyAppAhmedBundle:Default:ListDeRservation.html.twig',array('proprietes'=>$pros));
    }

    public function ListReservationByIdProprieteAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->ListReservationByPropriete($request->get('id'));

        return $this->render('MyAppAhmedBundle:Default:ListDeRservation.html.twig',array('proprietes'=>$pros));
    }
    public function notificationNbreDemandeAction()
    {

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->listProprieteByDemande($this->getUser()->getId());

        return $this->render('MyAppAhmedBundle:Default:NotificationNbreReservation.html.twig',array('proprietes'=>$pros));

    }
    public function NotificationConfirmationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->confirmationDemande($this->getUser()->getId());;



        return $this->render('MyAppAhmedBundle:Default:NotificationDeConfirmation.html.twig',array('proprietes'=>$pros));

    }
    function supprimerDemandeAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("MyAppAhmedBundle:Reservation")->findOneById($request->get('id'));
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute("my_app_ahmed_Demande_Reservation");
    }

    public function libererProprieteAction(Request $request )
    {

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Propriete")->find($request->get('id'));
        $pros->setDisponible('true');
        $em->flush();

        return $this->redirectToRoute("my_app_ahmed_Demande_Reservation");
    }
    public function topClientReservedtAction()
    {


        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->topClientReservedDQL();


        return $this->render('MyAppAhmedBundle:Default:TopClientReserved.html.twig',array('proprietes'=>$pros));
    }

    public function mesReservationAction()
    {

        $message=null;



        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->mesReservation($this->getUser()->getId());
        return $this->render('MyAppAhmedBundle:Default:MesReservation.html.twig',array('proprietes'=>$pros,'message'=>$message));


    }

    public function voirDetailReservationAction(Request $request)
    {
        $message=null;
        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->voirDetailDQL($request->get('id'));

        return $this->render('MyAppAhmedBundle:Default:VoirDetailleReservation.html.twig',array('proprietes'=>$pros ,'message'=>$message));
    }
    public function importerReservationExcelAction(Request $request)
    {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("liuggio")
            ->setLastModifiedBy("Giulio De Donato")
            ->setTitle("Office 2005 XLSX Test Document")
            ->setSubject("Office 2005 XLSX Test Document")
            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");

        $list=$this->get('session')->get('list');
        $i=3;
        foreach ($list as $r) {
            $phpExcelObject->setActiveSheetIndex(0)


                ->setCellValue('D'.(string)$i,'dateDebut')

                ->setCellValue('E'.(string)$i,$r['dtD'])
                ->setCellValue('F'.(string)$i,$r['dtF'])
                ->setCellValue('G'.(string)$i,$r['diff'])
                ->setCellValue('H'.(string)$i,$r['prix'])
                ->setCellValue('I'.(string)$i, $r['nom'])
                ->setCellValue('J'.(string)$i,$r['prenom'])

            ;
            $i++;
        }
        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'stream-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;



    }

    function annulerReservationAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("MyAppAhmedBundle:Reservation")->findOneById($request->get('id'));
        if ( $reservation->getEtat()=="false") {
            $em->remove($reservation);
            $em->flush();
            return $this->redirectToRoute("my_app_ahmed_Mes_Reservation");
        }

        $message="cette reservations est deja valider dans le system pour annuler contacter directement les proprioritaires";

        $em = $this->getDoctrine()->getManager();
        $pros = $em->getRepository("MyAppAhmedBundle:Reservation")->mesReservation($this->getUser()->getId());
        return $this->render('MyAppAhmedBundle:Default:MesReservation.html.twig',array('proprietes'=>$pros,'message'=>$message));

    }


}
