<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Accuracy
 *
 * @ORM\Table(name="accuracy")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccuracyRepository")
 */
class Accuracy
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
     * @ORM\Column(name="value", type="decimal", precision=4, scale=3, unique=true)
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="EqMode", mappedBy="accuracyClasses")
     */
    private $eqModes;

    /**
     * @ORM\ManyToMany(targetEntity="MeasurementRange", inversedBy="accuracyClasses")
     */
    private $measurementRanges;

    public function __construct()
    {
        $this->measurementRanges = new ArrayCollection();
        $this->eqModes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getValue();
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
     * Set value
     *
     * @param string $value
     *
     * @return Accuracy
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getEqModes()
    {
        return $this->eqModes;
    }

    public function getMeasurementRanges()
    {
        return $this->measurementRanges;
    }

    public function getDisplayName(){
        return $this->getValue() + 0;
    }
}

