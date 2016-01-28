<?php

namespace AppBundle\Model;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 09/01/2016
 * Time: 10:46
 */
class Flasher
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Flash a $type message
     *
     * @param string $type
     * @param string $message
     */
    public function flash($type = 'success', $message)
    {
        $this->session->getFlashBag()->add($type, $message);
    }

    /**
     * Flash a success message
     *
     * @param string $message
     */
    public function flashSuccess($message)
    {
        $this->session->getFlashBag()->add('success', $message);
    }

    /**
     * Flash a warning message
     *
     * @param string $message
     */
    public function flashWarning($message)
    {
        $this->session->getFlashBag()->add('warning', $message);
    }

    /**
     * Flash a danger message
     *
     * @param string $message
     */
    public function flashDanger($message)
    {
        $this->session->getFlashBag()->add('danger', $message);
    }
}
