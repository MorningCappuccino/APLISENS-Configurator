<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * EqMode
 *
 * @ORM\Table(name="eq_mode")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EqModeRepository")
 * @Vich\Uploadable()
 */
class EqMode
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var /AppBundle/Entity/EqType
     *
     * @ORM\ManyToOne(targetEntity="EqType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eqType;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    private $descr;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\ManyToMany(targetEntity="Accuracy", inversedBy="eqModes")
     *
     */
    private $accuracyClasses;

    /**
     * @ORM\ManyToMany(targetEntity="SpecialVersion", inversedBy="eqModes")
     */
    private $specialVersions;

    /**
     * @ORM\ManyToMany(targetEntity="MeasurementRange", inversedBy="eqModes")
     */
    private $measurementRanges;

    /**
     * @ORM\ManyToMany(targetEntity="BodyType", inversedBy="eqModes")
     */
    private $bodyTypes;

    /**
     * @ORM\ManyToMany(targetEntity="ProcessConnection", inversedBy="eqModes")
     */
    private $processConnections;

    /**
     * @ORM\ManyToMany(targetEntity="WeldedElement", mappedBy="eqModes")
     */
    private $weldedElements;

    /**
     * @ORM\ManyToMany(targetEntity="Brace", mappedBy="eqModes")
     */
    private $bracing;

    public function __construct()
    {
        $this->accuracyClasses = new ArrayCollection();
        $this->specialVersions = new ArrayCollection();
        $this->measurementRanges = new ArrayCollection();
        $this->bodyTypes = new ArrayCollection();
        $this->processConnections = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     *
     * @return EqMode
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set eqType
     *
     * @param integer $eqType
     *
     * @return EqMode
     */
    public function setEqType($eqType)
    {
        $this->eqType = $eqType;

        return $this;
    }

    /**
     * Get eqType
     *
     * @return int
     */
    public function getEqType()
    {
        return $this->eqType;
    }

    /**
     * Set descr
     *
     * @param string $descr
     *
     * @return EqMode
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;

        return $this;
    }

    /**
     * Get descr
     *
     * @return string
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * @return mixed
     */
    public function getAccuracyClasses()
    {
        return $this->accuracyClasses;
    }

    /**
     * @return mixed
     */
    public function getSpecialVersions()
    {
        return $this->specialVersions;
    }

    /**
     * @return mixed
     */
    public function hasMeasurementRanges()
    {
        return $this->measurementRanges;
    }

    /**
     * @return mixed
     */
    public function getBodyTypes()
    {
        return $this->bodyTypes;
    }

    /**
     * @return mixed
     */
    public function getProcessConnections()
    {
        return $this->processConnections;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return EqMode
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

//        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
//            $this->updatedAt = new \DateTime('now');
//        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return EqMode
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }


}

