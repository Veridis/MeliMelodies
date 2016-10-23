<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Contact;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/administration/contacts", name="admin-contacts")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->findAllOrdered();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($contacts, $request->query->getInt('page', 1), 10);

        return $this->render('admin/contact/contacts.html.twig', array(
            'contacts' => $pagination,
        ));
    }

    /**
     * @param Contact $contact
     * @return Response
     *
     * @Route("/administration/contacts/{id}", name="admin-contact-show")
     * @Method("GET")
     */
    public function showAction(Contact $contact)
    {
        return $this->render('admin/contact/show.html.twig', array(
            'contact' => $contact,
        ));
    }
}
