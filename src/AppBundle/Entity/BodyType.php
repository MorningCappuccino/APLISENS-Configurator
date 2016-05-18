<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BodyType
 *
 * @ORM\Table(name="body_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BodyTypeRepository")
 */
class BodyType
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
     * @ORM\ManyToMany(targetEntity="EqMode", mappedBy="bodyTypes")
     */
    private $eqModes;

    /**
     * @ORM\ManyToMany(targetEntity="SpecialVersion", mappedBy="bodyTypes")
     */
    private $specialVersions;


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
     * @return BodyType
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
     * @return BodyType
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
    public function getSpecialVersions()
    {
        return $this->specialVersions;
    }

    /**
     * @return mixed
     */
    public function getEqModes()
    {
        return $this->eqModes;
    }

//    /**
//     * Add EqModes
//     *
//     * @param EqMode $eq_mode
//     * @return BodyType
//     */
//    public function addEqMode(\AppBundle\Entity\EqMode $eq_mode)
//    {
//        $this->eqModes[] = $eq_mode;
//
//        return $this;
//    }
//
//
//    /**
//     * Add EqModes
//     *
//     * @param SpecialVersion $special_version
//     * @return BodyType
//     */
//    public function addSpecialVersion(\AppBundle\Entity\SpecialVersion $special_version)
//    {
//        $this->eqModes[] = $special_version;
//
//        return $this;
//    }
}

