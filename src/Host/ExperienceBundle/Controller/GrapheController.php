<?php

namespace Host\ExperienceBundle\Controller;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zend\Json\Expr;

class GrapheController extends Controller
{

    public function chartLineAction()
    {
        /*$em = $this->container->get('doctrine')->getEntityManager();*/
        $em = $this->getDoctrine()->getManager();
        $exps = $em->getRepository('HostExperienceBundle:Experience')->findAll();
        $tab = array();
        $categories = array();

        foreach ($exps as $ex) {
            array_push($tab, intval($ex->getParticipants()));
            array_push($categories, $ex->getNomXp());
        }


// Chart
        $series = array(
            array("name" => "Nom de l'expérience", "data" => $tab)
        );
        $ob = new Highchart();
        $ob->chart->renderTo('linechart'); // #id du div où afficher le graphe
        $ob->title->text('Nombre de participants par expérience');
        $ob->xAxis->title(array('text' => "User"));
        $ob->yAxis->title(array('text' => "id"));
        $ob->xAxis->categories($categories);
        $ob->series($series);
        return $this->render('@HostExperience/stat.html.twig',
            array(
                'chart' => $ob
            ));
    }


    public function chartHistogrammeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exps = $em->getRepository('HostExperienceBundle:Experience')->findAll();
        $tab = array();
        $categories = array();

        foreach ($exps as $ex) {
            array_push($tab, intval($ex->getParticipants()));
            array_push($categories, $ex->getNomXp());
        }
        $series = array(
            array(
                'name' => 'Id',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $tab,
            )
        );
        $yData = array(
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return
                        this.value + "" }'),
                    'style' => array('color' => '#4572A7')
                ),
                'gridLineWidth' => 0,
                'title' => array(
                    'text' => 'Nombre Id',
                    'style' => array('color' => '#4572A7')
                ),
            ),
        );
        $ob = new Highchart();
        $ob->chart->renderTo('container'); // The #id of the div where to render the chart
        $ob->chart->type('column');
        $ob->title->text('Nombre de participants par expérience');
        $ob->xAxis->categories($categories);
        $ob->yAxis($yData);
        $ob->legend->enabled(false);
        $formatter = new Expr('function () {var unit = {"Id": "Id(s)",}[this.series.name];return this.x + ": <b>" + this.y + "</b> " + unit;}');
        $ob->tooltip->formatter($formatter);
        $ob->series($series);
        return $this->render('@HostExperience/stat2.html.twig', array('chart' => $ob));
    }

    public function chartPieAction()
    {
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Id par User');
        $ob->plotOptions->pie(array(
            'allowPointSelect' => true,
            'cursor' => 'pointer',
            'dataLabels' => array('enabled' => false),
            'showInLegend' => true
        ));

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('EspritFithnytiBundle:User')->findAll();
        $totalId = 0;
        foreach ($users as $user) {
            $totalId = $totalId + $user->getId();
        }
        $data = array();
        foreach ($users as $user) {
            $stat = array();
            array_push($stat, $user->getNom(), (($user->getId()) * 100) / $totalId); //var_dump($stat);
            array_push($data, $stat);
        }       // var_dump($data);
        $ob->series(array(array('type' => 'pie', 'name' => 'Browsershare', 'data' => $data)));
        return $this->render('@EspritFithnyti/Admin/stat3.html.twig', array('chart' => $ob));
    }

}
