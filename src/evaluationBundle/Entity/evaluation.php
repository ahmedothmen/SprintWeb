<?php

namespace evaluationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity
 */
class evaluation
{
    /**
     * @var integer
     * @ORM\Column(name="id_e", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_e;
    /**
     * @var string
     *
     * @ORM\Column(name="type_d_acceuil", type="string", length=255, nullable=false)
     */
    private $type_d_acceuil ;
    /**
     * @var string
     *
     * @ORM\Column(name="etat_chambre", type="string", length=255, nullable=false)
     */
    private $etat_chambre ;

    /**
     * @var string
     *
     * @ORM\Column(name="caractere_host", type="string", length=255, nullable=false)
     */
    private $caractere_du_host;
    /**
     * @var string
     *
     * @ORM\Column(name="reglement", type="string", length=255, nullable=false)
     */
    private $reglement;
    /**
 * @var string
 *
 * @ORM\Column(name="qualite_prix", type="string", length=255, nullable=false)
 */
    private $qualite_prix;
    /**
     * @var string
     *
     * @ORM\Column(name="experience_globale", type="string", length=255, nullable=false)
     */
    private $experience_globale;

    /**
     * @return int
     */
    public function getIdE()
    {
        return $this->id_e;
    }

    /**
     * @param int $id_e
     */
    public function setIdE($id_e)
    {
        $this->id_e = $id_e;
    }

    /**
     * @return string
     */
    public function getTypeDAcceuil()
    {
        return $this->type_d_acceuil;
    }

    /**
     * @param string $type_d_acceuil
     */
    public function setTypeDAcceuil($type_d_acceuil)
    {
        $this->type_d_acceuil = $type_d_acceuil;
    }

    /**
     * @return string
     */
    public function getEtatChambre()
    {
        return $this->etat_chambre;
    }

    /**
     * @param string $etat_chambre
     */
    public function setEtatChambre($etat_chambre)
    {
        $this->etat_chambre = $etat_chambre;
    }

    /**
     * @return string
     */
    public function getCaractereDuHost()
    {
        return $this->caractere_du_host;
    }

    /**
     * @param string $caractere_du_host
     */
    public function setCaractereDuHost($caractere_du_host)
    {
        $this->caractere_du_host = $caractere_du_host;
    }

    /**
     * @return string
     */
    public function getReglement()
    {
        return $this->reglement;
    }

    /**
     * @param string $reglement
     */
    public function setReglement($reglement)
    {
        $this->reglement = $reglement;
    }

    /**
     * @return string
     */
    public function getQualitePrix()
    {
        return $this->qualite_prix;
    }

    /**
     * @param string $qualite_prix
     */
    public function setQualitePrix($qualite_prix)
    {
        $this->qualite_prix = $qualite_prix;
    }

    /**
     * @return string
     */
    public function getExperienceGlobale()
    {
        return $this->experience_globale;
    }

    /**
     * @param string $experience_globale
     */
    public function setExperienceGlobale($experience_globale)
    {
        $this->experience_globale = $experience_globale;
    }


}
