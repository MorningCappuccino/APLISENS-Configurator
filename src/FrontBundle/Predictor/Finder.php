<?php


namespace FrontBundle\Predictor;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class Finder extends Controller
{
    protected $container;
    protected $em;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $this->getDoctrine()->getManager();
    }

    private function getID($obj)
    {
        if( empty($obj) ) {
            return false;
        } else {
            return $obj->getId();
        }
    }

    public function isEqMode($name)
    {
        $query = $this->em->getRepository('AppBundle:EqMode')
            ->createQueryBuilder('e')
            ->select('e.id')
            ->where('e.name = :eq_mode_name')
            ->setParameter(':eq_mode_name', $name)
            ->setMaxResults(1)
            ->getQuery();
        $eq_mode = $query->getResult();
        if( empty( $eq_mode ) ) {
            return false;
        } else {
            return $eq_mode[0]['id'];
        }
    }

    public function isAccuracyClass($value)
    {
        $accuracy = $this->em->getRepository('AppBundle:Accuracy')
            ->findOneBy(['value' => $value]);
        if( empty($accuracy) ) {
            return false;
        } else {
            return $accuracy->getId();
        }
    }

    public function isSpecialVersion($name)
    {
        $sv = $this->em->getRepository('AppBundle:SpecialVersion')
            ->findOneBy(['name' => $name]);
        return $this->getID($sv);
    }

    /**
     * @param $theRange
     * @param $unit
     * @return bool
     */
    public function isMeasurementRange($theRange, $unit)
    {
        $query = $this->em->getRepository('AppBundle:MeasurementRange')
            ->createQueryBuilder('m')
            ->select('m.id')
            ->join('m.unit', 'u')
            ->where('m.theRange = :theRange')
            ->andWhere('u.name = :unit')
            ->setParameters([':theRange' => $theRange, ':unit' => $unit])
        ->getQuery();
        $mr = $query->getResult();
        if( empty( $mr ) ) {
            return false;
        } else {
            return $mr[0]['id'];
        }
    }

    public function isBodyType($name)
    {
        $obj = $this->em->getRepository('AppBundle:BodyType')
            ->findOneBy(['name' => $name]);
        return $this->getID($obj);
    }

    public function isProcessConnection($name)
    {
        $obj = $this->em->getRepository('AppBundle:ProcessConnection')
            ->findOneBy(['name' => $name]);
        return $this->getID($obj);
    }

    public function isValveUnit($name)
    {
        $obj = $this->em->getRepository('AppBundle:ValveUnit')
            ->findOneBy(['name' => $name]);
        return $this->getID($obj);
    }

    public function isWeldedElement($name)
    {
        $obj = $this->em->getRepository('AppBundle:WeldedElement')
            ->findOneBy(['name' => $name]);
        return $this->getID($obj);
    }

    public function isBracing($name)
    {
        $obj = $this->em->getRepository('AppBundle:Brace')
            ->findOneBy(['name' => $name]);
        return $this->getID($obj);
    }

    public function isCountryCode($name)
    {
        $obj = $this->em->getRepository('AppBundle:CountryCode')
            ->findOneBy(['name' => $name]);
        return $this->getID($obj);
    }
}