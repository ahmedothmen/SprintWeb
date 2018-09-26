<?php

namespace MyApp\UserBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\EvaluationRepositery")
 * @ORM\Table(name="evaluations")
 *
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="avis",type="string",length=255)
     * @Assert\NotBlank(message="Le champ d'avis ne doit pas être vide !")
     * @Assert\Length(
     * min = 10,
     * max = 250,
     * minMessage = "Votre avis doit avoir au moins {{ limit }} caractères !",
     * maxMessage = "Votre avis doit avoir au maximum {{ limit }} caractères !"
     * )
     */
    private $avis;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     *
     */
    private $user;
    /**
     * @ORM\Column(name="date",type="date")
     */
    private $date;

    private $captcha;
    private $message;

    /**
     * @ORM\Column(name="idE",type="string",length=255, nullable=true)
     *
     */
    private $idE;

    /**
     * @return mixed
     */
    public function getIdE()
    {
        return $this->idE;
    }

    /**
     * @param mixed $idE
     */
    public function setIdE($idE)
    {
        $this->idE = $idE;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

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
     * @ORM\Column(name="time",type="time")
     */
    private $time;
    /**
     * @ORM\Column(name="rating",type="string",length=255)
     * @Assert\NotNull(message="Merci de noter cette experience ")
     */
    private $rating;


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

    /**
     * @return mixed
     */
    public function getIdexp()
    {
        return $this->idexp;
    }

    /**
     * @param mixed $idexp
     */
    public function setIdexp($idexp)
    {
        $this->idexp = $idexp;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

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
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * @param mixed $avis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;
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

    public function __toString() {
        return $this->avis;
    }

    /**
     * @return mixed
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * @param mixed $captcha
     */
    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
    }



}