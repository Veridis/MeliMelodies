<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/accueil", name="home")
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
     * @Method("GET")
     */
    public function contactAction()
    {
        return $this->render('app/app/contact.html.twig');
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
     * @Route("/album", name="album")
     * @Method("GET")
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
