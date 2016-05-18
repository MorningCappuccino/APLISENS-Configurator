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
        return $this->render('@Front/list.html.twig', array('data' => $specialVersions));
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
                        ->orWhere('a.id = :accuracy_id') //in prod need "andWhere"
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
                        ->join('b.eqModes', 'e')
                        ->join('b.specialVersions', 's')
                        ->where('e.id = :eq_mode_id')
                        ->andWhere('s.id = :special_version_id') //in PROD -> 'andWhere'
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
                        ->join('p.eqModes', 'e')
                        ->join('p.specialVersions', 's')
                        ->where('e.id = :eq_mode_id')
                        ->andWhere('s.id = :special_version_id')
                ->setParameters([':eq_mode_id' => $eq_mode_id, ':special_version_id' => $special_version_id])
                ->getQuery();
        $processConnections = $query->getResult(2);
        return $this->render('FrontBundle::list.html.php', array('data' => $processConnections));
    }
}
