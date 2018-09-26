<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/04/2017
 * Time: 01:33
 */
namespace Host\ExperienceBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ExperienceRepository extends EntityRepository
{
    public function nbExp($id)
    {
        $query = $this->getEntityManager()->createQuery("select participants from experience e where e.id_xp=:id")->setParameter('id',$id);
        $query->getSingleScalarResult();
    }
}