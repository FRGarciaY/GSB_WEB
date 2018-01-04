<?php

namespace GSB\mainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $session = $this->get('session');
        if(!$session->has('identificated')){
            $session->set('identificated', false);
            return $this->redirectToRoute('gsb_login');
        }elseif($session->get('identificated', true)){
                return $this->render('GSBmainBundle:Main:index.html.twig');
        }else{
            return $this->redirectToRoute('gsb_login');
        }
    }
}