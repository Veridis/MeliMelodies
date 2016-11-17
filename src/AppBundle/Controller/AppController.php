<?php

namespace AppBundle\Controller;


use AppBundle\Entity\GuestBookPost;
use AppBundle\Entity\News;
use AppBundle\Form\GuestBookPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;


class AppController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="home")
     * @Method("GET")
     */
    public function homeAction()
    {
        return $this->render('app/app/home.html.twig');
    }

    /**
     * @return Response
     *
     * @Route("/presentation", name="presentation")
     * @Method("GET")
     */
    public function presentationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $members = $em->getRepository('AppBundle:Member')->findUnarchived();

        return $this->render('app/app/presentation.html.twig', array(
            'members' => $members,
        ));
    }

    /**
     * @param Request $request
     * @return Response
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

            $this->get('meli.flasher')->flashSuccess('Votre demande a bien été envoyée. Elle sera traitée dès que possible.');

            return $this->redirectToRoute('contact');
        }

        return $this->render('app/app/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return Response
     *
     * @Route("/presse", name="press")
     * @Method("GET")
     */
    public function pressAction()
    {
        return $this->render('app/app/press.html.twig');
    }

    /**
     * @return Response
     *
     * @Route("/multimedia/{category}", name="multimedia", requirements={ "category": "image|audio|video"})
     * @Method("GET")
     */
    public function albumAction($category)
    {
        return $this->render('app/app/album.html.twig', array(
            'category' => $category,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/livre-dor", name="guestbook")
     * @Method("GET")
     */
    public function guestbookAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:GuestBookPost')->findAllUnarchived();
        $form = $this->createForm(new GuestBookPostType(), new GuestBookPost(), array(
            'method' => 'POST',
            'action' => $this->generateUrl('guestbook-add')
        ));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $request->query->getInt('page', 1), 10);

        return $this->render('app/app/guestbook.html.twig', array(
            'posts' => $pagination,
            'form' => $form->createView(),
        ));
    }

    /**
     * @return Response
     *
     * @Route("/agenda", name="agenda")
     * @Method("GET")
     */
    public function agendaAction()
    {
        return $this->render('app/app/agenda.html.twig');
    }

    /**
     * @return Response
     *
     * @Route("/cgu", name="cgu")
     * @Method("GET")
     */
    public function cguAction()
    {
        return $this->render('app/app/cgu.html.twig');
    }

    /**
     * @return Response
     *
     * @Route("/mentions-legales", name="legals")
     * @Method("GET")
     */
    public function legalsAction()
    {
        return $this->render('app/app/legals.html.twig');
    }
}
