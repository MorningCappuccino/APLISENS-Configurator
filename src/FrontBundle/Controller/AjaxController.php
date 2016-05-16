<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
    /**
     * @Route("/")
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
                        ->andWhere('a.id = :accuracy_id')
                ->setParameters([':eq_mode_id' => $eq_mode_id, ':accuracy_id' => $accuracy_id])
//                  ->setParameter(':eq_mode_id', $eq_mode_id)
                ->getQuery();
        $measurementRanges = $query->getResult(2);
        return $this->render('FrontBundle::measurementRangesList.html.php', array('data' => $measurementRanges, 'query' => $query ));
    }
}
