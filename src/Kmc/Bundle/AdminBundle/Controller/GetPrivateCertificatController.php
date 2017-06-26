<?php
namespace Kmc\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Kmc\Bundle\KmcBundle\Entity\Subscription;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;


class GetPrivateCertificatController extends Controller
{
	
	public function privateCertificatImageAction($subscription_id)
	{
		$subscritpion= $this->getDoctrine()
							->getRepository('KmcKmcBundle:Subscription')
							->find($subscription_id);
		if(empty($subscritpion->getCertificat()))
		{
			return new Response(null);
		}
		$file = $subscritpion->getCertificat();
		$response = new BinaryFileResponse($file);
		// you can modify headers here, before returning
		return $response;
		
		
	}
	
	public function privateMenberCertificatImageAction ($member_season_id)
	{
		$memberseason = $this->getDoctrine()
							->getRepository('KmcAdminBundle:MemberSeason')
							->find($member_season_id);
		if(empty($memberseason->getCertificat()))
		{
			return new Response(null);
		}
		$file = $memberseason->getCertificat();
		$response = new BinaryFileResponse($file);
		// you can modify headers here, before returning
		return $response;
	}

}