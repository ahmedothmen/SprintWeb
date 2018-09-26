<?php

namespace MyApp\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: Haroun
 * Date: 05/04/2017
 * Time: 22:00
 */
class EvaluationRepositery extends EntityRepository

{

    public function AVGrating($id)
    {
        $query = $this->getEntityManager()->createQuery("select avg(r.rating) as Moy from MyAppUserBundle:Evaluation r WHERE r.idE='$id' ");
        return $query->getSingleScalarResult();
    }


}