<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AdminController extends Controller
{
    /**
     * @Route("/administration", name="admin")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render('admin/admin/index.html.twig');
    }
}
