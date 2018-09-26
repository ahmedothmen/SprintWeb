<?php

namespace ProprieteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorispropriete
 *
 * @ORM\Table(name="favorispropriete")
 * @ORM\Entity(repositoryClass="ProprieteBundle\Repository\ProprieteRatingRepository")
 */
class Favorispropriete
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
     * @var integer
     *
     * @ORM\Column(name="idP", type="integer", nullable=false)
     */
    private $idp;

    /**
     * @var integer
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

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
     * @return int
     */
    public function getIdp()
    {
        return $this->idp;
    }

    /**
     * @param int $idp
     */
    public function setIdp($idp)
    {
        $this->idp = $idp;
    }

    /**
     * @return int
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * @param int $idu
     */
    public function setIdu($idu)
    {
        $this->idu = $idu;
    }


}

