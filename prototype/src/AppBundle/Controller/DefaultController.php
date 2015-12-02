<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
    	$session = $request->getSession();
    	if($session == null) {
    		$session = new Session();
    	}
    	if(!$session->isStarted()) {
    		$session->start();
    	}
        return $this->render('default/index.html.twig');
    }
}
