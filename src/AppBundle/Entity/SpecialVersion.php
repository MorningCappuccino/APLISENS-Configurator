<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialVersion
 *
 * @ORM\Table(name="special_version")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecialVersionRepository")
 */
class SpecialVersion
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
     * @ORM\Column(name="name", type="string", length=30, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    private $descr;

    /**
     * @ORM\ManyToMany(targetEntity="EqMode", mappedBy="specialVersions")
     */
    private $eqModes;

    /**
     * @ORM\ManyToMany(targetEntity="BodyType", inversedBy="specialVersions")
     */
    private $bodyTypes;

    /**
     * @ORM\ManyToMany(targetEntity="ProcessConnection", inversedBy="specialVersions")
     */
    private $processConnections;

    public function __construct()
    {
        $this->bodyTypes = new ArrayCollection();
        $this->processConnections = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return SpecialVersion
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
     * @return SpecialVersion
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

