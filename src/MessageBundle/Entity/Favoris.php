<?php
/**
 * Created by PhpStorm.
 * User: Oussaa
 * Date: 28/03/2017
 * Time: 02:57
 */

namespace MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris")
 * @ORM\Entity(repositoryClass="MessageBundle\Repository\MessageRepository")
 */
class Favoris
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_f", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var integer
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     *
     * @var integer
     * @ORM\Column(name="id_favoris", type="integer")
     */
    private $idFavoris;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", nullable=true)
     */
    private $alias;

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
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return integer
     */
    public function getIdFavoris()
    {
        return $this->idFavoris;
    }

    /**
     * @param int $idFavoris
     */
    public function setIdFavoris($idFavoris)
    {
        $this->idFavoris = $idFavoris;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }










}