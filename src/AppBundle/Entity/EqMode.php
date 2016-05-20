<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EqMode
 *
 * @ORM\Table(name="eq_mode")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EqModeRepository")
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
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     */
    private $img;

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
     * Set img
     *
     * @param string $img
     *
     * @return EqMode
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
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


}

