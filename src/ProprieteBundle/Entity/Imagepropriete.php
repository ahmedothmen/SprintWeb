<?php

namespace ProprieteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imagepropriete
 *
 * @ORM\Table(name="imagepropriete", indexes={@ORM\Index(name="id_p", columns={"id_p"}), @ORM\Index(name="id_p_2", columns={"id_p"})})
 * @ORM\Entity
 */
class Imagepropriete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_i", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idI;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=200, nullable=false)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_p", type="integer", nullable=false)
     */
    private $idP;

    /**
     * @return int
     */
    public function getIdI()
    {
        return $this->idI;
    }

    /**
     * @param int $idI
     */
    public function setIdI($idI)
    {
        $this->idI = $idI;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
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



}

