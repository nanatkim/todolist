<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IdxController extends Controller
{
    /**
    * @Route("/", name="index")
    */
    public function indexAction()
    {
        return $this->render('index/index.html.twig');  
    }

    /**
     * @Route("/if", name="iflogout")
     */
    public function ifAction()
    {
        return $this->render('iflogout.html.twig');
    }

    /**
     * @Route("/message", name="ifmsg")
     */
    public function msgAction()
    {
        return $this->render('/todo/loginMessage.html.twig');
    }
}
