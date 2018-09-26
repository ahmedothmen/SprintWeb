<?php
namespace MyApp\AhmedBundle\Entity;
use Doctrine\ORM\Mapping as  ORM ;

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 22/03/2017
 * Time: 21:18
 */

/**
 * @ORM\Entity(repositoryClass="MyApp\AhmedBundle\Repository\ReservationRepository")
 * @ORM\Table(name="reservation")
 */

class Reservation
{

    /**
     * @ORM\Column(name="id_r",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue (strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="dateDebut",type="date")
     */
    private $dateDebut;
    /**
     * @ORM\Column(name="dateReservation",type="date")
     */
    private $dateRservation;
    public function __construct()
    {
        $this->dateRservation = new \DateTime();
    }

    /**
     * @ORM\Column(name="dateFin",type="date")
     */
    private $dateFin;
    /**
     * @ORM\Column(name="id_u",type="integer")
     * @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\User" )
     */

    private $user;
    /**
     * @ORM\Column(name="id_p",type="integer")
     * @ORM\ManyToOne(targetEntity="ProprieteBundle\Entity\Propriete" )
     * @ORM\JoinColumn(name="id_p", referencedColumnName="id_p")
     */
    private $propriete;
    /**
     * @ORM\Column(name="etat",type="string",length=100)
     */
    private $etat;
    /**
     * @ORM\Column(name="id_ud",type="integer")
     * @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\User" )
     */
    private $userDemandant;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = new \DateTime($dateDebut);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = new \DateTime($dateFin);
        return $this;

    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPropriete()
    {
        return $this->propriete;
    }

    /**
     * @param mixed $propriete
     */
    public function setPropriete($propriete)
    {
        $this->propriete = $propriete;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getUserDemandant()
    {
        return $this->userDemandant;
    }

    /**
     * @param mixed $userDemandant
     */
    public function setUserDemandant($userDemandant)
    {
        $this->userDemandant = $userDemandant;
    }

    /**
     * @return mixed
     */
    public function getDateRservation()
    {
        return $this->dateRservation;
    }

    /**
     * @param mixed $dateRservation
     */
    public function setDateRservation($dateRservation)
    {
        $this->dateRservation = new \DateTime();
        return $this;


    }



}