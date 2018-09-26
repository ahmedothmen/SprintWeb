<?php
namespace Host\ExperienceBundle\Entity;
use Doctrine\ORM\Mapping as ORM ;
use Symfony\Component\HttpFoundation\File\File;use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/03/2017
 * Time: 18:06
 */
/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Experience
{
    /**
     * @ORM\Column(name="id_xp",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_xp;
    /**
     * @ORM\Column(name="description",type="text",nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(name="type",type="string",length=20,nullable=true)
     */
    private $type;
/**
* @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\User" , inversedBy="Experience")
* @ORM\JoinColumn(name="id_user" , referencedColumnName="id")
*/
    private $id_user;
    /**
     * @ORM\Column(name="id_p",type="integer",nullable=true)
     */
    private $id_p;
    /**
     * @ORM\Column(name="nom_xp",type="string",length=255,nullable=true)
     */
    private $nom_xp;
    /**
     * @ORM\Column(name="arrival",type="date",nullable=true)
     */
    private $arrival;
    /**
     * @ORM\Column(name="departure",type="date",nullable=true)
     */
    private $departure;
    /**
     * @ORM\Column(name="participants",type="integer",nullable=true)
     */
    private $participants;
    /**
     * @ORM\Column(name="prix_xp",type="float",nullable=true)
     */
    private $prix_xp;


    /**
     * @return mixed
     */
    public function getIdXp()
    {
        return $this->id_xp;
    }

    /**
     * @param mixed $id_xp
     */
    public function setIdXp($id_xp)
    {
        $this->id_xp = $id_xp;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getIdP()
    {
        return $this->id_p;
    }

    /**
     * @param mixed $id_p
     */
    public function setIdP($id_p)
    {
        $this->id_p = $id_p;
    }

    /**
     * @return mixed
     */
    public function getNomXp()
    {
        return $this->nom_xp;
    }

    /**
     * @param mixed $nom_xp
     */
    public function setNomXp($nom_xp)
    {
        $this->nom_xp = $nom_xp;
    }

    /**
     * @return mixed
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param mixed $arrival
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;
    }

    /**
     * @return mixed
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param mixed $departure
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    /**
     * @return mixed
     */
    public function getPrixXp()
    {
        return $this->prix_xp;
    }

    /**
     * @param mixed $prix_xp
     */
    public function setPrixXp($prix_xp)
    {
        $this->prix_xp = $prix_xp;
    }


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;


    /**
     * @ORM\Column(type="datetime",nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Experience
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Experience
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }


}