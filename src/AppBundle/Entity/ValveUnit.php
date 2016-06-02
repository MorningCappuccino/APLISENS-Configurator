<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ValveUnit
 *
 * @ORM\Table(name="valve_unit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ValveUnitRepository")
 */
class ValveUnit
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
     * @ORM\ManyToMany (targetEntity="ProcessConnection", inversedBy="valveUnits")
     */
    private $processConnections;

    /**
     * @ORM\ManyToMany(targetEntity="WeldedElement", mappedBy="valveUnits")
     *
     */
    private $weldedElements;

    public function __construct()
    {
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
     * @return ValveUnit
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
     * @return ValveUnit
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

}
