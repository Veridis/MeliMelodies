<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/administration", name="admin")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Admin:index.html.twig');
    }
}
