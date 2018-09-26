<?php

namespace ProprieteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Propriete
 *
 * @ORM\Table(name="propriete", indexes={@ORM\Index(name="id_u", columns={"id_u"})})
 * @ORM\Entity(repositoryClass="ProprieteBundle\Repository\ProprieteRatingRepository")
 */
class Propriete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_p", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idP;

    /**
     * @var string
     *
     * @ORM\Column(name="categoriePropriete", type="string", length=80, nullable=false)
     */
    private $categoriepropriete;

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
     * @var string
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="typePropriete", type="string", length=80, nullable=false)
     */
    private $typepropriete;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=80, nullable=false)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=80, nullable=false)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="rue", type="string", length=80, nullable=false)
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=80, nullable=false)
     */
    private $titre;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrChambre", type="integer", nullable=false)
     */
    private $nbrchambre;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrVoyageur", type="integer", nullable=false)
     */
    private $nbrvoyageur;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="animaux", type="boolean", nullable=false)
     */
    private $animaux;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fumeur", type="boolean", nullable=false)
     */
    private $fumeur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="alcool", type="boolean", nullable=false)
     */
    private $alcool;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enfant", type="boolean", nullable=false)
     */
    private $enfant;

    /**
     * @var integer
     *
     * @ORM\Column(name="likes", type="integer", nullable=true)
     */
    private $likes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_u", type="integer", nullable=false)
     */
    private $idU;

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
     * @return string
     */
    public function getCategoriepropriete()
    {
        return $this->categoriepropriete;
    }

    /**
     * @param string $categoriepropriete
     */
    public function setCategoriepropriete($categoriepropriete)
    {
        $this->categoriepropriete = $categoriepropriete;
    }

    /**
     * @return string
     */
    public function getTypepropriete()
    {
        return $this->typepropriete;
    }

    /**
     * @param string $typepropriete
     */
    public function setTypepropriete($typepropriete)
    {
        $this->typepropriete = $typepropriete;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * @param string $rue
     */
    public function setRue($rue)
    {
        $this->rue = $rue;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return int
     */
    public function getNbrchambre()
    {
        return $this->nbrchambre;
    }

    /**
     * @param int $nbrchambre
     */
    public function setNbrchambre($nbrchambre)
    {
        $this->nbrchambre = $nbrchambre;
    }

    /**
     * @return int
     */
    public function getNbrvoyageur()
    {
        return $this->nbrvoyageur;
    }

    /**
     * @param int $nbrvoyageur
     */
    public function setNbrvoyageur($nbrvoyageur)
    {
        $this->nbrvoyageur = $nbrvoyageur;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isAnimaux()
    {
        return $this->animaux;
    }

    /**
     * @param bool $animaux
     */
    public function setAnimaux($animaux)
    {
        $this->animaux = $animaux;
    }

    /**
     * @return bool
     */
    public function isFumeur()
    {
        return $this->fumeur;
    }

    /**
     * @param bool $fumeur
     */
    public function setFumeur($fumeur)
    {
        $this->fumeur = $fumeur;
    }

    /**
     * @return bool
     */
    public function isAlcool()
    {
        return $this->alcool;
    }

    /**
     * @param bool $alcool
     */
    public function setAlcool($alcool)
    {
        $this->alcool = $alcool;
    }

    /**
     * @return bool
     */
    public function isEnfant()
    {
        return $this->enfant;
    }

    /**
     * @param bool $enfant
     */
    public function setEnfant($enfant)
    {
        $this->enfant = $enfant;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
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


}

