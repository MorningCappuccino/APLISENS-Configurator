<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProcessConnection
 *
 * @ORM\Table(name="process_connection")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcessConnectionRepository")
 */
class ProcessConnection
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
     * @ORM\Column(name="name", type="string", length=15, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    private $descr;

    /**
     * @ORM\ManyToMany(targetEntity="EqMode", mappedBy="processConnections")
     */
    private $eqModes;

    /**
     * @ORM\ManyToMany(targetEntity="SpecialVersion", mappedBy="processConnections")
     */
    private $specialVersions;

    /**
     * @ORM\ManyToMany(targetEntity="ValveUnit", mappedBy="processConnections")
     */
    private $valveUnits;

    /**
     * @ORM\ManyToMany(targetEntity="WeldedElement", mappedBy="processConnections")
     */
    private $weldedElements;

    /**
     * @ORM\ManyToMany(targetEntity="Brace", mappedBy="processConnections")
     */
    private $bracing;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eqModes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->specialVersions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valveUnits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function __toString()
    {
        return $this->getName();
    }


    /**
     * Get id
     *
     * @return integer
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
     * @return ProcessConnection
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
     * Set descr
     *
     * @param string $descr
     *
     * @return ProcessConnection
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
     * Add eqMode
     *
     * @param \AppBundle\Entity\EqMode $eqMode
     *
     * @return ProcessConnection
     */
    public function addEqMode(\AppBundle\Entity\EqMode $eqMode)
    {
        $this->eqModes[] = $eqMode;

        return $this;
    }

    /**
     * Remove eqMode
     *
     * @param \AppBundle\Entity\EqMode $eqMode
     */
    public function removeEqMode(\AppBundle\Entity\EqMode $eqMode)
    {
        $this->eqModes->removeElement($eqMode);
    }

    /**
     * Get eqModes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEqModes()
    {
        return $this->eqModes;
    }

    /**
     * Add specialVersion
     *
     * @param \AppBundle\Entity\SpecialVersion $specialVersion
     *
     * @return ProcessConnection
     */
    public function addSpecialVersion(\AppBundle\Entity\SpecialVersion $specialVersion)
    {
        $this->specialVersions[] = $specialVersion;

        return $this;
    }

    /**
     * Remove specialVersion
     *
     * @param \AppBundle\Entity\SpecialVersion $specialVersion
     */
    public function removeSpecialVersion(\AppBundle\Entity\SpecialVersion $specialVersion)
    {
        $this->specialVersions->removeElement($specialVersion);
    }

    /**
     * Get specialVersions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecialVersions()
    {
        return $this->specialVersions;
    }

    /**
     * @return mixed
     */
    public function getValveUnits()
    {
        return $this->valveUnits;
    }


}
