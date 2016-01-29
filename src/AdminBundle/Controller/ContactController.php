<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Contact;

class ContactController extends Controller
{
    /**
     * @Route("/administration/contacts", name="admin-contacts")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('AppBundle:Contact')->findAllOrdered();

        return $this->render('admin/contact/contacts.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * @param Contact $contact
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @Route("/administration/contacts/{id}", name="admin-contact-show")
     * @Method({"GET"})
     * @ParamConverter("contact", class="AppBundle:Contact")
     */
    public function showAction(Contact $contact)
    {
        return $this->render('admin/contact/show.html.twig', array(
            'contact' => $contact,
        ));
    }
}
