<?php

namespace ProprieteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentairepropriete
 *
 * @ORM\Table(name="commentairepropriete", indexes={@ORM\Index(name="id_p", columns={"id_p"}), @ORM\Index(name="id_u", columns={"id_u"})})
 * @ORM\Entity(repositoryClass="ProprieteBundle\Repository\ProprieteRatingRepository")
 */
class Commentairepropriete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=200, nullable=true)
     */
    private $contenu;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_p", type="integer", nullable=true)
     */
    private $idP;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_u", type="integer", nullable=true)
     */
    private $idU;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    /**
     *
     * @ORM\Column(name="rating", type="string", nullable=true)
     */
    private $rating;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return int
     */
    public function getIdP()
    {
        return $this->idP;
    }

    /**
     * @param int $idP
     */
    public function setIdP($idP)
    {
        $this->idP = $idP;
    }

    /**
     * @return int
     */
    public function getIdU()
    {
        return $this->idU;
    }

    /**
     * @param int $idU
     */
    public function setIdU($idU)
    {
        $this->idU = $idU;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }



    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }


}

