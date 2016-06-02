<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brace
 *
 * @ORM\Table(name="brace")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BraceRepository")
 */
class Brace
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
     * @ORM\Column(name="name", type="string", length=20, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    private $descr;

    /**
     * @ORM\ManyToMany(targetEntity="ProcessConnection", inversedBy="bracing")
     */
    private $processConnections;

    /**
     * @ORM\ManyToMany(targetEntity="BodyType", inversedBy="bracing")
     */
    private $bodyTypes;

    /**
     * @ORM\ManyToMany(targetEntity="EqMode", inversedBy="bracing")
     */
    private $eqModes;

    public function __construct()
    {
        $this->processConnections = new ArrayCollection();
        $this->bodyTypes = new ArrayCollection();
        $this->eqModes = new ArrayCollection();
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
     * @return Brace
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
     * @return Brace
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
    public function getBodyTypes()
    {
        return $this->bodyTypes;
    }

    /**
     * @return mixed
     */
    public function getEqModes()
    {
        return $this->eqModes;
    }


}

