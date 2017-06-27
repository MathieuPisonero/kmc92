<?php
namespace Kmc\Bundle\KmcBundle\Utils;

use Kmc\Bundle\KmcBundle\Entity\Subscription;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

class ImageLoader
{
	private $container;
	
	private $em;
	
	public function __construct(ContainerInterface $container, EntityManager $em)
	{
		$this->container = $container;
		$this->em = $em;
	}
	
	public function isTmpCertificat(subscription $subscription)
	{
		if(!empty($subscription->getCertificat()))
		{
			return true;
		}
		return false;
	}
	
	public function setFileName(subscription $subscription, Request $request)
	{
		if(!empty($subscription->getCertificat()))
		{
			$file = $subscription->getCertificat();
			$fileName = $request->getSession()->getId().'.'.$file->guessExtension();
			$file->move( $this->container->getParameter('imgcertif_temp_path') ,$fileName );
			$subscription->setCertificat( $this->container->getParameter('imgcertif_temp_path') . $fileName);
			return $subscription;
		}
		return $subscription;
	}
	
	public function saveCertificat(subscription $subscription)
	{
		if(empty($subscription->getCertificat()))
			return $subscription;
		$file = new File($subscription->getCertificat());
		$file->move($this->container->getParameter("imgcertif_path"));
		$subscription->setCertificat($this->container->getParameter("imgcertif_path").$file->getFilename());
		return $subscription;
	}
	
	public function CopyMemberCertificat(subscription $subscription)
	{
		if(empty($subscription->getCertificat()))
			return null;
		$file = new File($subscription->getCertificat());
		$fs = new Filesystem();
		if($fs->exists($file->getPathname()))
		{
			$memberCertifPath = $this->container->getParameter("imgcertif_member_path");
			$fs->copy($file->getPathname(),$memberCertifPath . $file->getFilename());
			return $memberCertifPath . $file->getFilename();
		}

		return null;
	}
	
	public function DeleteMemberCertificat($memberseason)
	{
		$certificat = $memberseason->getCertificat();
		$fs = new Filesystem();
		$fs->remove($certificat);
		$memberseason->setCertificat(null);
		return $memberseason;
	}
	
	public function uploadNewCertificatMemberSeason($file, $memberseason)
	{
		
		$file->move($this->container->getParameter("imgcertif_member_path"),$memberseason->getId().'.'.$file->getClientOriginalExtension());
		$memberseason->setCertificat($this->container->getParameter("imgcertif_member_path") . $memberseason->getId().'.'.$file->getClientOriginalExtension());
		return($memberseason);
	}
	
	public function uploadStageImage($file ,$stage)
	{
		if(!empty($file))
		{
			$file->move($this->container->getParameter("imgstage_path"),$stage->getUrlKey().'.'.$file->getClientOriginalExtension());
			$stage->setImage($this->container->getParameter("imgstage_URI") . $stage->getUrlKey().'.'.$file->getClientOriginalExtension());
		}
		return $stage;
	}
}