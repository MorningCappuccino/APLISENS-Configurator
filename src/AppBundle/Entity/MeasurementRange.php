<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeasurementRange
 *
 * @ORM\Table(name="measurement_range")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeasurementRangeRepository")
 */
class MeasurementRange
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
     * @ORM\Column(name="theRange", type="string", length=20)
     */
    private $theRange;

    /**
     * @var Units
     * @ORM\ManyToOne(targetEntity="Units")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit;

    /**
     * @ORM\ManyToMany(targetEntity="EqMode", mappedBy="measurementRanges")
     */
    private $eqModes;

    /**
     * @ORM\ManyToMany(targetEntity="Accuracy", mappedBy="measurementRanges")
     */
    private $accuracyClasses;

    public function __toString()
    {
        return $this->theRange;
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
     * Set theRange
     *
     * @param string $theRange
     *
     * @return MeasurementRange
     */
    public function setTheRange($theRange)
    {
        $this->theRange = $theRange;

        return $this;
    }

    /**
     * Get theRange
     *
     * @return string
     */
    public function getTheRange()
    {
        return $this->theRange;
    }

    /**
     * Set unit
     *
     * @param integer $unit
     *
     * @return MeasurementRange
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return int
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     *
     */
    public function getDisplayName()
    {
        return $this->theRange .' '. $this->unit;
    }
}

