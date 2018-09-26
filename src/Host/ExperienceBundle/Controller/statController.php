<?php

namespace Host\ExperienceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ob\HighchartsBundle\Highcharts\Highchart;

class statController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function statAction()
    { /* $user = $this->getUser();
        $idd =  $this->getUser()->getId();
        $email = $this->getUser()->getemail();*/



        $em=$this->getDoctrine()->getManager();
        // $Hotel = $em->getRepository('GstayhotelBundle:Hotel')->findOneBy(array('id_user' => $idd ));





        $events=$em->getRepository("HostExperienceBundle:Experience")->findAll();

        $count = array();

        foreach ($events as $event) {
            //   $event=$em->getRepository("HostExperienceBundle:Experience")->find(array('id'=>$id));


            $d =array( $event->getParticipants(),$event->getNomXp());
            array_push($count,$d);
        }

        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Reservations per Offer');

        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false,
                'format' => '{point.name}: {point.y:.1f}%'),
            'showInLegend'  => true
        ));
        $data =$count;

        $ob->series(array(array('type' => 'pie','name' => 'Title', 'data' => $data)));
        return $this->render('HostExperienceBundle::linechart.html.twig',array('chart'=>$ob));

    }
}
