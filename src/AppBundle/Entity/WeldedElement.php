<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * WeldedElement
 *
 * @ORM\Table(name="welded_element")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WeldedElementRepository")
 */
class WeldedElement
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    private $descr;

    /**
     * @ORM\ManyToMany(targetEntity="ProcessConnection", inversedBy="weldedElements")
     */
    private $processConnections;

    /**
     * @ORM\ManyToMany(targetEntity="ValveUnit", inversedBy="weldedElements")
     */
    private $valveUnits;

    /**
     * @ORM\ManyToMany(targetEntity="EqMode", inversedBy="weldedElements")
     */
    private $eqModes;

    public function __construct()
    {
        $this->processConnections = new ArrayCollection();
        $this->valveUnits = new Arraycollection();
        $this->eqModes = new Arraycollection();
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
     * @return WeldedElement
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
     * @return WeldedElement
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
    public function getProcessConnections()
    {
        return $this->processConnections;
    }

    /**
     * @return mixed
     */
    public function getValveUnits()
    {
        return $this->valveUnits;
    }

    /**
     * @return mixed
     */
    public function getEqModes()
    {
        return $this->eqModes;
    }



}

