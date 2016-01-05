<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param $name string
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/hello/{name}", name="hello")
     */
    public function testAction($name)
    {
        return $this->render('app/default/hello.html.twig', array('name' => $name));
    }
}
