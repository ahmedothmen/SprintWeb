<?php

namespace ProprieteBundle\Repository;
use Doctrine\ORM\EntityRepository;
class ProprieteRatingRepository extends EntityRepository
{
    public function AVGRating($idP)
    {
        $query=$this->getEntityManager()->createQuery("select avg(c.rating) as moy from ProprieteBundle:Commentairepropriete c where c.idP='$idP'");
        return $query->getSingleScalarResult();



    }
    public function listPropriete()
    {

        $query = $this->getEntityManager()->createQuery("select count(p.idP) as nb from ProprieteBundle:Propriete p");
        return $query->getSingleScalarResult();
    }
    public function listProprieteByUser($idU)
    {

        $query = $this->getEntityManager()->createQuery("select count(p.idP) as nb from ProprieteBundle:Propriete p where p.idU='$idU'");
        return $query->getSingleScalarResult();
    }
    public function listCommentaireByProp($idP)
    {

        $query = $this->getEntityManager()->createQuery("select count(c.id) as nb from ProprieteBundle:Commentairepropriete c where c.idP='$idP'");
        return $query->getSingleScalarResult();
    }
    public function listProprieteByPrixD()
    {
        $query = $this->getEntityManager()->createQuery("select p from ProprieteBundle:Propriete p GROUP BY p.prix ORDER BY p.prix DESC ");
        return $query->getResult();
    }
    public function listProprieteByPrixA()
    {
        $query = $this->getEntityManager()->createQuery("select p from ProprieteBundle:Propriete p ORDER BY p.prix ASC ");
        return $query->getResult();
    }
    public function listProprieteByRatingAsc()
    {
        $query = $this->getEntityManager()->createQuery("select p,avg(c.rating) as ag ,p.idP as idP,p.titre as titre,p.pays as pays,p.description as description, p.nbrchambre as nbrChambre, p.nbrvoyageur as nbrVoyageur ,p.prix as prix from ProprieteBundle:Propriete p ,ProprieteBundle:Commentairepropriete c WHERE p.idP=c.idP GROUP BY ag ORDER BY ag ASC ");
        return $query->getResult();
    }
    public function listProprieteByRatingDesc()
    {
        $query = $this->getEntityManager()->createQuery("select p,avg(c.rating) as ag ,p.idP as idP,p.titre as titre,p.pays as pays,p.description as description, p.nbrchambre as nbrChambre, p.nbrvoyageur as nbrVoyageur ,p.prix as prix from ProprieteBundle:Propriete p ,ProprieteBundle:Commentairepropriete c WHERE p.idP=c.idP GROUP BY ag ORDER BY ag DESC ");
        return $query->getResult();
    }
    public function afficherPropFavoris($idU){
        $query = $this->getEntityManager()->createQuery("select p from ProprieteBundle:Propriete p ,ProprieteBundle:Favorispropriete f where f.idp=p.idP and f.idu='$idU'");
        return $query->getResult();

    }

}