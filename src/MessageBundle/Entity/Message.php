<?php

namespace MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="MessageBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_m", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var integer
     * @ORM\Column(name="id_e", type="integer")
     */
    private $idE;

    /**
     * @var integer
     * @ORM\Column(name="id_r", type="integer")
     */
    private $idR;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date", nullable=true)
     *
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(name="dossier", type="string", nullable=true, options={"default" : "Inbox"})
     *
     */
    private $dossier;

    /**
     * @var string
     * @ORM\Column(name="label", type="string", nullable=true)
     *
     */
    private $label;

    /**
     * @var string
     * @ORM\Column(name="subject", type="string", nullable=true)
     *
     */
    private $subject;

    /**
     * @var integer
     * @ORM\Column(name="isRead", type="boolean", nullable=true, options={"default" : "0"})
     *
     */
    private $isRead;

    /**
     * @var integer
     * @ORM\Column(name="isResponse", type="boolean", nullable=true, options={"default" : "0"})
     *
     */
    private $isResponse;

    /**
     * @var integer
     * @ORM\Column(name="idMessageBase", type="integer", nullable=true)
     */
    private $idMessageBase;

    /**
     * @return integer
     */
    public function getIdMessageBase()
    {
        return $this->idMessageBase;
    }

    /**
     * @param int $idMessageBase
     */
    public function setIdMessageBase($idMessageBase)
    {
        $this->idMessageBase = $idMessageBase;
    }

    /**
     * @return integer
     */
    public function getIsResponse()
    {
        return $this->isResponse;
    }

    /**
     * @param int $isResponse
     */
    public function setIsResponse($isResponse)
    {
        $this->isResponse = $isResponse;
    }

    /**
     * @return integer
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * @param integer $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @var string
     * @ORM\Column(name="np", type="string", nullable=true)
     *
     */
    private $np;

    /**
     * @ORM\Column(name="time", type="time", nullable=true)
     */
    private $time;

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getNp()
    {
        return $this->np;
    }

    /**
     * @param string $np
     */
    public function setNp($np)
    {
        $this->np = $np;
    }

    /**
     * @return mixed
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * @param mixed $dossier
     */
    public function setDossier($dossier)
    {
        $this->dossier = $dossier;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set idE
     *
     * @param integer $idE
     *
     * @return Message
     */
    public function setIdE($idE)
    {
        $this->idE = $idE;

        return $this;
    }

    /**
     * Get idE
     *
     * @return integer
     */
    public function getIdE()
    {
        return $this->idE;
    }

    /**
     * Set idR
     *
     * @param integer $idR
     *
     * @return int
     */
    public function setIdR($idR)
    {
        $this->idR = $idR;

        return $this;
    }

    /**
     * Get idR
     *
     * @return integer
     */
    public function getIdR()
    {
        return $this->idR;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Message
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

