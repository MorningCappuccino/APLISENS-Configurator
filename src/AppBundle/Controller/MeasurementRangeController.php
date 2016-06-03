<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MeasurementRange;
use AppBundle\Form\MeasurementRangeType;

/**
 * MeasurementRange controller.
 *
 * @Route("/measurementrange")
 */
class MeasurementRangeController extends Controller
{
    /**
     * Lists all MeasurementRange entities.
     *
     * @Route("/", name="measurementrange_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $measurementRanges = $em->getRepository('AppBundle:MeasurementRange')->findBy([],['unit' => 'ASC', 'theRange' => 'ASC']);

        return $this->render('measurementrange/index.html.twig', array(
            'measurementRanges' => $measurementRanges,
        ));
    }

    /**
     * Creates a new MeasurementRange entity.
     *
     * @Route("/new", name="measurementrange_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $measurementRange = new MeasurementRange();
        $form = $this->createForm('AppBundle\Form\MeasurementRangeType', $measurementRange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //check unique measurement range
            $range = $measurementRange->getTheRange();
            $unit = $measurementRange->getUnit()->getName();
            $query = $em->getRepository('AppBundle:MeasurementRange')
                        ->createQueryBuilder('m')
                        ->join('m.unit', 'u')
                        ->where('m.theRange = :range')
                        ->andWhere('u.name = :unit')
                    ->setParameters([':range' => $range, ':unit' => $unit])
                    ->setMaxResults(1)
                    ->getQuery();
            $is_exist_range = $query->getResult();
            if (!empty($is_exist_range)) {
               $msg = 'Eah! The range "'. $range .' '. $unit .'" already exist!';
               $this->addFlash('warning', $msg);

                return $this->redirectToRoute('measurementrange_new');
            }
            $em->persist($measurementRange);
            $em->flush();

            return $this->redirectToRoute('measurementrange_index');
        }

        return $this->render('measurementrange/new.html.twig', array(
            'measurementRange' => $measurementRange,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MeasurementRange entity.
     *
     * @Route("/{id}", name="measurementrange_show")
     * @Method("GET")
     */
    public function showAction(MeasurementRange $measurementRange)
    {
        $deleteForm = $this->createDeleteForm($measurementRange);

        return $this->render('measurementrange/show.html.twig', array(
            'measurementRange' => $measurementRange,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MeasurementRange entity.
     *
     * @Route("/{id}/edit", name="measurementrange_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MeasurementRange $measurementRange)
    {
        $deleteForm = $this->createDeleteForm($measurementRange);
        $editForm = $this->createForm('AppBundle\Form\MeasurementRangeType', $measurementRange);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($measurementRange);
            $em->flush();

            return $this->redirectToRoute('measurementrange_index');
        }

        return $this->render('measurementrange/edit.html.twig', array(
            'measurementRange' => $measurementRange,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MeasurementRange entity.
     *
     * @Route("/{id}", name="measurementrange_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MeasurementRange $measurementRange)
    {
        $form = $this->createDeleteForm($measurementRange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($measurementRange);
            $em->flush();
        }

        return $this->redirectToRoute('measurementrange_index');
    }

    /**
     * Creates a form to delete a MeasurementRange entity.
     *
     * @param MeasurementRange $measurementRange The MeasurementRange entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MeasurementRange $measurementRange)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('measurementrange_delete', array('id' => $measurementRange->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
