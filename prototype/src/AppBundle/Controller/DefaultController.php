<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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

		//new sessionID if session existed already.
		$session->migrate();
		if($session->has('originalSessionID')) {
			$session->remove('originalSessionID');
		}

        return $this->render('default/index.html.twig');
    }

	/**
	 * @Route("/video", name="video")
	 *
	 * Serving video allowing to handle Range and If-Range headers from the request.
	 */
	public function videoServing(Request $request) {
		$file = $this->getParameter('assetic.write_to').$this->container->get('templating.helper.assets')->getUrl('video/CreateSafe.mp4');
		$response = new BinaryFileResponse($file);
		BinaryFileResponse::trustXSendfileTypeHeader();
		$response->prepare($request);
		return $response;
	}
}
