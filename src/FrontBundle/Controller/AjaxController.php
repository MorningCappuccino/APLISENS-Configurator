<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
    /**
     * @Route(name="ajaxSearch")
     */
    public function liveSearch(Request $request)
    {
        $searchText = $request->get('searchText');
        $eq_modes = $this->getDoctrine()->getRepository('AppBundle:EqMode')
            ->findByLetters($searchText);
//       return new Response('I\'m live search'.' '.$searchText);
        return $this->render('eqmode/table.html.twig', array('eqModes' => $eq_modes));
    }

    /**
     * @Route("/", name="ajax")
     */
    public function indexAction(Request $request)
    {
        $actionName = $request->get('action_name');
//        $this->{$actionName}();
//        return new Response('param-pam-pam'.': '.$actionName);
        return $this->$actionName($request);
    }

    public function getAllEqMode($request)
    {
//        $data = $request->getContent();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(''
                            . 'SELECT e.id, e.name '
                            . 'FROM AppBundle:EqMode e '
                            . 'ORDER BY e.name'
                             );
        $eq_modes = $query->getResult();
//        return new Response('get and pay'.': '. var_dump($eq_modes));
        return $this->render('@Front/list.html.twig', array('data' => $eq_modes));
    }

    public function getAccuracyClassesByEqModeID($request)
    {
        $eq_mode_id = $request->get('eq_mode_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Accuracy')
                    ->createQueryBuilder('a')
                    ->join('a.eqModes', 'e')
                    ->where('e.id = :eq_mode_id')
                    ->orderBy('a.value', 'ASC')
/*                    createQuery('
                             SELECT a.id, a.value, e
                             FROM AppBundle:Accuracy a
                             JOIN AppBundle:EqMode e
                             WHERE e.id = :eq_mode_id'
                                  )*/
                ->setParameter(':eq_mode_id', $eq_mode_id)
                ->getQuery();
        $accuracyClasses = $query->getResult(2);
        foreach ($accuracyClasses as $key => $value){
            $accuracyClasses[$key]['name'] = $accuracyClasses[$key]['value'];
         }
        return $this->render('FrontBundle::accuracyList.html.php', array('data' => $accuracyClasses));
    }

    public function getSpecialVersionsByEqModeID($request)
    {
        $eq_mode_id = $request->get('eq_mode_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:SpecialVersion')
                        ->createQueryBuilder('s')
                        ->join('s.eqModes', 'e')
                        ->where('e.id = :eq_mode_id')
                        ->orderBy('s.name', 'ASC')
                    ->setParameter(':eq_mode_id', $eq_mode_id)
                    ->getQuery();
        $specialVersions = $query->getResult(2);
        return $this->render('FrontBundle::SpecialVersionList.html.php', array('data' => $specialVersions));
    }

    public function getMeasurementRangesByEqModeIDAndAccuracyID($request)
    {
        $eq_mode_id = $request->get('eq_mode_id');
        $accuracy_id = $request->get('accuracy_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:MeasurementRange')
                        ->createQueryBuilder('m')
                        ->select('m.id', 'm.theRange', 'u.name unit')
                        ->join('m.eqModes', 'e')
                        ->join('m.accuracyClasses', 'a')
                        ->join('m.unit', 'u')
                        ->where('e.id = :eq_mode_id')
                        ->andWhere('a.id = :accuracy_id') //in prod need "andWhere"
                ->setParameters([':eq_mode_id' => $eq_mode_id, ':accuracy_id' => $accuracy_id])
//                  ->setParameter(':eq_mode_id', $eq_mode_id)
                ->getQuery();
        $measurementRanges = $query->getResult(2);
        return $this->render('FrontBundle::measurementRangesList.html.php', array('data' => $measurementRanges, 'query' => $query ));
    }

    public function getBodyTypesByEqModeIDAndSpecialVersionID($request)
    {
        $eq_mode_id = $request->get('eq_mode_id');
        $special_version_id = $request->get('special_version_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:BodyType')
                        ->createQueryBuilder('b')
                        ->distinct(true) //in PROD may without distinct
                        ->join('b.eqModes', 'e')
                        ->join('b.specialVersions', 's')
                        ->where('e.id = :eq_mode_id')
                        ->orWhere('s.id = :special_version_id') //in PROD -> 'andWhere'
                ->setParameters([':eq_mode_id' => $eq_mode_id, ':special_version_id' => $special_version_id])
                ->getQuery();
        $bodyTypes = $query->getResult(2);
        return $this->render('FrontBundle::list.html.php', array('data' => $bodyTypes));
    }

    public function getProcessConnectionByEqModeIDAndSpecialVersionID($request)
    {
        $eq_mode_id = $request->get('eq_mode_id');
        $special_version_id = $request->get('special_version_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:ProcessConnection')
                        ->createQueryBuilder('p')
                        ->distinct(true) //in PROD may without distinct
                        ->join('p.eqModes', 'e')
                        ->join('p.specialVersions', 's')
                        ->where('e.id = :eq_mode_id')
                        ->orWhere('s.id = :special_version_id') //in PROD -> 'andWhere'
                ->setParameters([':eq_mode_id' => $eq_mode_id, ':special_version_id' => $special_version_id])
                ->getQuery();
        $processConnections = $query->getResult(2);
        return $this->render('FrontBundle::list.html.php', array('data' => $processConnections));
    }

    public function getValveUnitByProcessConnectionID($request)
    {
        $process_connection_id = $request->get('process_connection_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:ValveUnit')
                        ->createQueryBuilder('v')
                        ->join('v.processConnections', 'p')
                        ->where('p.id = :process_connection_id')
                ->setParameter(':process_connection_id', $process_connection_id)
                ->getQuery();
        $valveUnits = $query->getResult(2);
        return $this->render('FrontBundle::valveUnitList.html.php', array('data' => $valveUnits));
    }

    public function getWeldedElementByEqModeProcessConnectionValveUnitID($request)
    {
        $eq_mode_id = $request->get('eq_mode_id');
        $process_connection_id = $request->get('process_connection_id');
        $valve_unit_id = $request->get('valve_unit_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:WeldedElement')
                        ->createQueryBuilder('w')
                        ->distinct(true)
                        ->join('w.processConnections', 'p')
                        ->join('w.valveUnits', 'v')
                        ->join('w.eqModes', 'e')
                        ->where('p.id = :process_connection_id')
                        ->andWhere('v.id = :valve_unit_id')
                        ->orWhere('e.id = :eq_mode_id')
                ->setParameters([':process_connection_id' => $process_connection_id,
                             ':valve_unit_id' => $valve_unit_id,
                             ':eq_mode_id' => $eq_mode_id])
//                ->setParameter(':process_connection_id', $process_connection_id)
                ->getQuery();
        $weldedElements = $query->getResult(2);
        return $this->render('FrontBundle::weldedElementsList.html.php', array('data' => $weldedElements));
    }

    public function getBracingByProcessConnectionBodyTypeEqMode($request)
    {
        $eq_mode_id = $request->get('eq_mode_id');
        $process_connection_id = $request->get('process_connection_id');
        $body_type_id = $request->get('body_type_id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Brace')
                        ->createQueryBuilder('b')
                        ->join('b.processConnections', 'p')
                        ->join('b.bodyTypes', 'bo')
                        ->join('b.eqModes', 'e')
                        ->where('p.id = :process_connection_id')
                        ->andWhere('bo.id = :body_type_id')
                        ->andWhere('e.id = :eq_mode_id')
                    ->setParameters([':process_connection_id' => $process_connection_id,
                                     ':body_type_id' => $body_type_id,
                                     ':eq_mode_id' => $eq_mode_id])
                    ->getQuery();
        $braces = $query->getResult(2);
        return $this->render('FrontBundle::BraceList.html.php', array('data' => $braces));
    }

    public function getAllCountryCodes(){
        $em = $this->getDoctrine()->getManager();
        $countryCodes = $em->getRepository('AppBundle:CountryCode')
                            ->createQueryBuilder('c')
                            ->getQuery()
                            ->getResult(2);
        return $this->render('FrontBundle::list.html.php', array('data' => $countryCodes));
    }

    public function generate($request)
    {
        $em = $this->getDoctrine()->getManager();

        $params = $request->get('params');
        $eq_mode_id = $params['eqModeID'];
        $accuracy_id = $params['accuracyID'];
        $special_version_id = $params['specialVersionID'];
        if (isset($params['ContOtherSpecVers']['ids'])){
            $otherSpecialVersions_ids = $params['ContOtherSpecVers']['ids'];
            $otherSpecialVersions = $em->getRepository('AppBundle:SpecialVersion')->findBy(['id' => $otherSpecialVersions_ids]);
        } else {
            $otherSpecialVersions = null;
        }
        $measurement_range_id = $params['measurementRangeID'];
        $another_measurement_range = $params['anotherMeasurementRange'];
        $body_type_id = $params['bodyTypeID'];
				$tube_length = $params['tubeLength'];
        $process_connection_id = $params['processConnectionID'];
        $valve_unit_id = $params['valveUnitID'];
        $welded_element_id = $params['weldedElementID'];
        $brace_id = $params['braceID'];
        $country_code_id = $params['countryCodeID'];

        $eqMode = $em->getRepository('AppBundle:EqMode')->findOneBy(['id' => $eq_mode_id]);
        $accuracy = $em->getRepository('AppBundle:Accuracy')->findOneBy(['id' => $accuracy_id]);
        $specialVersion = $em->getRepository('AppBundle:SpecialVersion')->findOneBy(['id' => $special_version_id]);
        $measurementRange = $em->getRepository('AppBundle:MeasurementRange')->findOneBy(['id' => $measurement_range_id]);
        $bodyType = $em->getRepository('AppBundle:BodyType')->findOneBy(['id' => $body_type_id]);
        $processConnection = $em->getRepository('AppBundle:ProcessConnection')->findOneBy(['id' => $process_connection_id]);
        $valveUnit = $em->getRepository('AppBundle:ValveUnit')->findOneBy(['id' => $valve_unit_id]);
        $weldedElement = $em->getRepository('AppBundle:WeldedElement')->findOneBy(['id' => $welded_element_id]);
        $brace = $em->getRepository('AppBundle:Brace')->findOneBy(['id' => $brace_id]);
        $countryCode = $em->getRepository('AppBundle:CountryCode')->findOneBy(['id' => $country_code_id]);
        return $this->render('FrontBundle::jumbotron.html.twig', array(
            'eqMode' => $eqMode,
            'accuracy' => $accuracy,
            'specialVersion' => $specialVersion,
            'otherSpecialVersions' => $otherSpecialVersions,
            'measurementRange' => $measurementRange,
            'anotherMeasurementRange' => $another_measurement_range,
            'bodyType' => $bodyType,
            'tubeLength' => $tube_length,
            'processConnection' => $processConnection,
            'valveUnit' => $valveUnit,
            'weldedElement' => $weldedElement,
            'brace' => $brace,
            'countryCode' => $countryCode
        ));
    }
}
