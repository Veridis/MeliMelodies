<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;


class AppController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function homeAction()
    {
        return $this->render('app/app/home.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/presentation", name="presentation")
     * @Method("GET")
     */
    public function presentationAction()
    {
        return $this->render('app/app/presentation.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/contact", name="contact")
     * @Method({"GET", "POST"})
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType(), new Contact(), array(
            'action' => $this->generateUrl('contact'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($form->getData()->getFiles() as $file) {
                $file->upload();
            }
            $em->persist($form->getData());
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('Votre demande a bien été envoyée. Elle sera traitée sous peu.');

            return $this->redirectToRoute('contact');
        }

        return $this->render('app/app/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/press", name="press")
     * @Method("GET")
     */
    public function pressAction()
    {
        return $this->render('app/app/press.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/multimedia", name="multimedia")
     * @Method("GET")s
     */
    public function albumAction()
    {
        return $this->render('app/app/album.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/livre-dor", name="guestbook")
     * @Method("GET")
     */
    public function guestbookAction()
    {
        return $this->render('app/app/guestbook.html.twig');
    }
}
