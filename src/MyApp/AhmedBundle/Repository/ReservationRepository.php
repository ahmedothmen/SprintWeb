<?php
namespace MyApp\AhmedBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 22/03/2017
 * Time: 22:00
 */
class ReservationRepository extends EntityRepository
{
    public function findProprieteDQL()
    {

        $query = $this->getEntityManager()->createQuery(" SELECT im.url as url ,p.idP,p.description as des,p.prix as prix,p.ville as vil,p.categoriepropriete as cat FROM  ProprieteBundle:Propriete p ,ProprieteBundle:Imagepropriete im WHERE im.idI=p.idP  GROUP BY p.idP");
        return $query->getResult();
    }

    public function MostResevedDQL()
    {

        $query = $this->getEntityManager()->createQuery(" SELECT im.url as url ,p.idP,p.description as des,p.prix as prix,p.ville as ville,p.categoriepropriete as cat,COUNT ( m.propriete) as nb FROM  MyAppAhmedBundle:Reservation m, ProprieteBundle:Propriete p ,ProprieteBundle:Imagepropriete im WHERE p.idP=m.propriete and im.idP=p.idP and m.etat='true' GROUP BY m.propriete  ORDER BY nb DESC ");
        return $query->getResult();



    }

    public function nbreReservation($id)
    {
        $query = $this->getEntityManager()->createQuery("select count( m.propriete) as nb from MyAppAhmedBundle:Reservation m  WHERE m.propriete='$id' and m.etat='true'");
        return $query->getSingleScalarResult();

    }

    public function voirDetailDQL($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT im.url as url ,p.idP,p.description as des,p.prix as prix,p.ville as vil,p.categoriepropriete as cat,COUNT ( m.propriete) as nb FROM  MyAppAhmedBundle:Reservation m,ProprieteBundle:Propriete  p ,ProprieteBundle:Imagepropriete im WHERE p.idP=m.propriete and im.idP=p.idP and im.idP='$id' ");
        return $query->getResult();



    }

    public function findProprieteByCategorieDQL($cat)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT im.url as url ,p.idP,p.description as des,p.prix as prix,p.ville as vil,p.categoriepropriete as cat FROM  ProprieteBundle:Propriete p ,ProprieteBundle:Imagepropriete im WHERE p.idP=m.propriete and im.idP=p.idP and p.categoriepropriete='$cat' GROUP BY p.idP ");
        return $query->getResult();
    }

    public function findProprieteByVilleDQL($ville)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT im.url as url ,p.idP,p.description as des,p.prix as prix,p.ville as vil,p.categoriepropriete as cat,COUNT ( m.propriete) as nb FROM  MyAppAhmedBundle:Reservation m,ProprieteBundle:Propriete  p ,ProprieteBundle:Imagepropriete im WHERE p.idP=m.propriete and im.idP=p.idP  and p.ville='$ville' GROUP BY m.propriete ORDER BY nb DESC");
        return $query->getResult();
    }


    public function findProprieteByVilleAndCategorieDQL($ville,$cat)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT im.url as url ,p.idP,p.description as des,p.prix as prix,p.ville as vil,p.categoriepropriete as cat,COUNT ( m.propriete) as nb FROM  MyAppAhmedBundle:Reservation m,ProprieteBundle:Propriete  p ,ProprieteBundle:Imagepropriete im WHERE p.idP=m.propriete and im.idP=p.idP  and p.ville='$ville'and p.categoriepropriete='$cat' GROUP BY m.propriete ORDER BY nb DESC");
        return $query->getResult();
    }

    public function findDemandeNonValider($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT u.id as idU,u.nom as nom ,u.prenom as prenom , m.id as id_r, p.idP as idp,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF ,date_diff(m.dateFin ,m.dateDebut)as diff FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete p ,MyAppUserBundle:User u   WHERE p.idP=m.propriete and u.id=m.userDemandant and  m.etat='false' and m.user='$id' ");
        return $query->getResult();
    }

    public function validerDemande($id)
    {

       $this->getEntityManager()->createQueryBuilder()
            ->update('MyAppAhmedBundle:Reservation', 'd')
            ->set('d.etat', 'true')
            ->where('d.id' == ':v')
            ->setParameter('v', $id)
            ->getQuery()
            ->execute();

           $query = $this->getEntityManager()->executeQuery(" UPDATE MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete  p   WHERE p.idP=");

    }

    public function listProprieteByDemande($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT  p.titre, im.url as url ,p.idP,p.description as des,p.prix as prix,p.ville as vil,p.categoriepropriete as cat,COUNT ( m.id) as nb FROM  MyAppAhmedBundle:Reservation m,ProprieteBundle:Propriete p ,ProprieteBundle:Imagepropriete im WHERE p.idP=m.propriete and im.idP=p.idP and m.etat='false' and p.idU='$id' GROUP BY m.propriete ORDER BY nb DESC");
        return $query->getResult();
    }

    public function facture($id_r)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT u.id as idU,u.nom as nom ,u.prenom as prenom , m.id as id_r, p.idP as idp,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF ,date_diff(m.dateFin ,m.dateDebut)as diff FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete  p ,MyAppUserBundle:User u   WHERE p.idP=m.propriete and u.id=m.userDemandant and  m.id='$id_r' ");
        return $query->getResult();
    }



    public function findDemandeNonValiderByIdPropriete($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT u.id as idU,u.nom as nom ,u.prenom as prenom , m.id as id_r, p.idP as idp,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF ,date_diff(m.dateFin ,m.dateDebut)as diff FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete p ,MyAppUserBundle:User u   WHERE p.idP=m.propriete and u.id=m.userDemandant and  m.etat='false' and m.propriete='$id' ");
        return $query->getResult();
    }
    public function NbreDeJourRestant($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT date_diff(m.dateFin ,CURRENT_DATE())as diff, im.url as url ,p.idP,p.titre FROM  MyAppAhmedBundle:Reservation m,ProprieteBundle:Propriete p ,ProprieteBundle:Imagepropriete im WHERE p.idP=m.propriete and im.idP=p.idP and m.etat='true' and m.dateFin>=CURRENT_DATE() and p.idU='$id'  GROUP BY diff ORDER BY diff ASC ");
        return $query->getResult();
    }

    public function listChambreLibreByDemande($debut,$fin)
    {
        $query = $this->getEntityManager()->createQuery("SELECT  p.idP,p.description as des,p.prix as prix,p.ville as vil,p.categoriepropriete as cat,COUNT ( m1.propriete) as nb FROM  MyAppAhmedBundle:Reservation m1, ProprieteBundle:Propriete p LEFT OUTER JOIN MyAppAhmedBundle:Reservation m  WITH ( p.id = m.propriete AND ( '$debut'>= m.dateDebut AND $debut <= m.dateFin OR ('$fin'>= m.dateDebut AND $fin<=m.dateFin) OR (m.dateDebut >= $debut AND m.dateDebut<= $fin )OR (m.dateFin >= $debut AND m.dateFin<=$fin) ) )" );
        return $query->getResult();
    
    
    }



    public function ListProprieteByUser($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT  u.nom as nom , u.prenom as prenom, date_diff(m.dateFin ,m.dateDebut)as diff , im.url as url, m.id as id_r, p.idP,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF,COUNT ( m.id) as nb FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete  p ,ProprieteBundle:Imagepropriete im ,MyAppUserBundle:User u    WHERE p.idP=m.propriete and p.idP=im.idP and m.etat='true' and m.user='$id' and m.userDemandant=u.id  GROUP BY m.propriete ORDER BY nb DESC ");
        return $query->getResult();
    }


    public function ListReservationByPropriete($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT u.nom as nom , u.prenom as prenom, date_diff(m.dateFin ,m.dateDebut)as diff , im.url as url, m.id as id_r, p.idP,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF,COUNT ( m.id) as nb FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete  p ,ProprieteBundle:Imagepropriete im ,MyAppUserBundle:User u    WHERE p.idP=m.propriete and p.idP=im.idP and m.etat='true' and m.propriete='$id' and m.userDemandant=u.id GROUP BY m.id ");
        return $query->getResult();
    }

    public function confirmationDemande($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT m.id as ll, m.etat, u.nom as nom , u.prenom as prenom, date_diff(CURRENT_DATE() ,m.dateRservation )as diff , im.url as url, m.id as id_r, p.idP,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete  p ,ProprieteBundle:Imagepropriete im ,MyAppUserBundle:User u    WHERE p.idP=m.propriete and p.idP=im.idP   and m.userDemandant='$id' and m.dateDebut> CURRENT_DATE() GROUP BY m.id ");
        return $query->getResult();
    }

    public function deletDemande($id)
    {
        $etat='false';
        $query = $this->getEntityManager()->createQuery('DELETE    MyAppAhmedBundle:Reservation buss WHERE buss.etat=:et and buss.propriete=:bussId')
            ->setParameter("bussId",$id)
            ->setParameter("et",$etat);
       $query->execute();
    }
    public function verifierAvantReserver($id,$id_p)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT m.id as ll, m.etat  FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete  p ,ProprieteBundle:Imagepropriete im ,MyAppUserBundle:User u    WHERE  m.userDemandant='$id' and m.propriete='$id_p' and m.etat='false'");
        return $query->getResult();
    }

    public function topClientReservedDQL()
    {

        $query = $this->getEntityManager()->createQuery(" SELECT u.nom as nom , u.prenom as prenom , u.imgurl as url ,COUNT (m.userDemandant) as nb FROM  MyAppAhmedBundle:Reservation m ,MyAppUserBundle:User u  WHERE m.userDemandant=u.id and m.etat='true'  GROUP BY u.id ORDER BY nb DESC ");
        return $query->getResult();



    }
    public function mesReservation($id)
    {

        $query = $this->getEntityManager()->createQuery(" SELECT u.id as idU,u.nom as nom ,u.prenom as prenom , m.id as id_r, p.idP as idp,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF ,date_diff(m.dateFin ,m.dateDebut)as diff FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete p ,MyAppUserBundle:User u   WHERE p.idP=m.propriete and u.id=m.userDemandant  and m.userDemandant='$id' ");
        return $query->getResult();
    }


    public function reservationAdmin()
    {

        $query = $this->getEntityManager()->createQuery(" SELECT u.id as idU,u.nom as nom ,u.prenom as prenom , m.id as id_r, p.id as idp,p.titre as tit,p.prix as prix,p.ville as vil,p.categoriepropriete as cat ,m.dateDebut as dtD ,m.dateFin as dtF ,date_diff(m.dateFin ,m.dateDebut)as diff FROM  MyAppAhmedBundle:Reservation m ,ProprieteBundle:Propriete  p ,MyAppUserBundle:User u   WHERE p.idP=m.propriete and u.id=m.userDemandant");
        return $query->getResult();
    }

}