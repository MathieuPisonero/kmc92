<?php
namespace Kmc\Bundle\KmcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Kmc\Bundle\KmcBundle\Entity\Subscription;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class GetPrivateCertificatController extends Controller
{
	
	public function privateTempCertificatImageAction(request $request)
	{
		$session = $request->getSession();
		$subscription = $session->get('subscription');
		$file = $subscription->getCertificat();
		$response = new BinaryFileResponse($file);
		// you can modify headers here, before returning
		return $response;
		
		
	}
}