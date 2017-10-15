<?php

namespace Kmc\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kmc\Bundle\AdminBundle\Form\Type\PriceFormType;
use Kmc\Bundle\AdminBundle\Form\Type\SeasonFormType;
use Kmc\Bundle\AdminBundle\Form\Type\ClubFormType;
use Kmc\Bundle\AdminBundle\Form\Type\InformationFormType;
use Kmc\Bundle\AdminBundle\Form\Type\AnswerFormType;
use Kmc\Bundle\AdminBundle\Form\Type\MemberFormType;
use Kmc\Bundle\AdminBundle\Form\Type\MemberSeasonFormType;
use Kmc\Bundle\AdminBundle\Form\Type\NewMemberFormType;
use Kmc\Bundle\KmcBundle\Entity\InformationQuestion;
use Kmc\Bundle\KmcBundle\Entity\InformationAnswer;
use Kmc\Bundle\KmcBundle\Entity\City;
use Kmc\Bundle\KmcBundle\Entity\Season;
use Kmc\Bundle\KmcBundle\Entity\Price;
use Kmc\Bundle\AdminBundle\Entity\Member;
use Kmc\Bundle\AdminBundle\Entity\MemberSeason;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ContentController extends Controller
{
	public function UploadAction($attr, Request $request)
	{
		$file= $request->files->get($attr);
		$helper = $this->get("kmc_admin.content.upload");
		$file = $helper->uploadFile($file,"tmp");
		$response = new Response(json_encode($file));
		return $response;
	}
	
	public function DownloadAction($context, $filename )
	{
		$helper = $this->get("kmc_admin.content.download");
		$file = $helper->getPathFile($filename,$context);
		$response = new BinaryFileResponse($file);
		return $response;
	}
	
}