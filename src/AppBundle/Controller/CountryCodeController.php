<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CountryCode;
use AppBundle\Form\CountryCodeType;

/**
 * CountryCode controller.
 *
 * @Route("/countrycode")
 */
class CountryCodeController extends Controller
{
    /**
     * Lists all CountryCode entities.
     *
     * @Route("/", name="countrycode_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $countryCodes = $em->getRepository('AppBundle:CountryCode')->findAll();

        return $this->render('countrycode/index.html.twig', array(
            'countryCodes' => $countryCodes,
        ));
    }

    /**
     * Creates a new CountryCode entity.
     *
     * @Route("/new", name="countrycode_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $countryCode = new CountryCode();
        $form = $this->createForm('AppBundle\Form\CountryCodeType', $countryCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($countryCode);
            $em->flush();

            return $this->redirectToRoute('countrycode_show', array('id' => $countryCode->getId()));
        }

        return $this->render('countrycode/new.html.twig', array(
            'countryCode' => $countryCode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CountryCode entity.
     *
     * @Route("/{id}", name="countrycode_show")
     * @Method("GET")
     */
    public function showAction(CountryCode $countryCode)
    {
        $deleteForm = $this->createDeleteForm($countryCode);

        return $this->render('countrycode/show.html.twig', array(
            'countryCode' => $countryCode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CountryCode entity.
     *
     * @Route("/{id}/edit", name="countrycode_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CountryCode $countryCode)
    {
        $deleteForm = $this->createDeleteForm($countryCode);
        $editForm = $this->createForm('AppBundle\Form\CountryCodeType', $countryCode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($countryCode);
            $em->flush();

            return $this->redirectToRoute('countrycode_edit', array('id' => $countryCode->getId()));
        }

        return $this->render('countrycode/edit.html.twig', array(
            'countryCode' => $countryCode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CountryCode entity.
     *
     * @Route("/{id}", name="countrycode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CountryCode $countryCode)
    {
        $form = $this->createDeleteForm($countryCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($countryCode);
            $em->flush();
        }

        return $this->redirectToRoute('countrycode_index');
    }

    /**
     * Creates a form to delete a CountryCode entity.
     *
     * @param CountryCode $countryCode The CountryCode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CountryCode $countryCode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('countrycode_delete', array('id' => $countryCode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
