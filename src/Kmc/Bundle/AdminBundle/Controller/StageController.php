<?php

namespace Kmc\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kmc\Bundle\KmcBundle\Entity\Season;
use Kmc\Bundle\KmcBundle\Entity\Price;
use Kmc\Bundle\AdminBundle\Entity\Member;
use Kmc\Bundle\AdminBundle\Entity\MemberSeason;
use Kmc\Bundle\AdminBundle\Entity\Stage;
use Kmc\Bundle\AdminBundle\Form\Type\StageFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class StageController extends Controller
{
	
	public function ListAction()
	{
		$menu = array('stage','list');
		$repository_stage= $this->getDoctrine()
							   ->getRepository('KmcAdminBundle:Stage');
		$stages = $repository_stage->findAll();
		$subcount = array();
		// 	 finir
		
		foreach ($stages as $stage)
		{
			$count = $repository_stage->countSubscription($stage->getId());
			if( empty($count))
				$subcount[$stage->getId()] = 0;
			else
				$subcount[$stage->getId()] = $count[0]['nb'];
		}
		return $this->render('KmcAdminBundle:Stage:List.html.twig',array('menu'=>$menu,'stages'=>$stages,'subcount'=>$subcount));
	}
	
	public function EditAction($stageId, Request $request)
	{
		$menu = array('stage','list');
		$repository_stage= $this->getDoctrine()
							   ->getRepository('KmcAdminBundle:Stage');
		$stage = $repository_stage->find($stageId);
		$form = $this->createForm(StageFormType::class, $stage);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$file = $stage->getImage();
			$helper = $this->get("kmc_kmc.imageloader");
			$stage= $helper->uploadStageImage($file,$stage);
			$em = $this->getDoctrine()->getManager();
			$em->persist($stage);
			$em->flush();
		}
		return $this->render('KmcAdminBundle:Stage:Edit.html.twig',array('menu'=>$menu,'stage'=>$stage,'form'=>$form->createView()));
	}
	
	public function NewAction(Request $request)
	{
		$menu = array('stage','new');
		$stage = new Stage();
		$stage->setDateStart(new \DateTime('now',new \DateTimeZone('EUROPE/Paris')));
		$stage->setDateEnd(new \DateTime('now',new \DateTimeZone('EUROPE/Paris')));
		$form = $this->createForm(StageFormType::class, $stage);
		$form->handleRequest($request);
		if ($form->isValid()) {
			$repository= $this->getDoctrine()->getRepository('KmcAdminBundle:Stage');
			$key = $repository->GenKey($stage->getName());
			
			$stage->setUrlKey($key);
			$file = $stage->getImage();
			//gestion de l'image
			$helper = $this->get("kmc_kmc.imageloader");
			$stage= $helper->uploadStageImage($file,$stage);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($stage);
			$em->flush();
			return $this->redirect($this->generateUrl('kmc_admin_stage_edit',array('stageId' => $stage->getId())));
		}
		return $this->render('KmcAdminBundle:Stage:New.html.twig',array('menu'=>$menu, 'form'=>$form->createView()));
	}
	
	public function StageSubscriptionListAction($stageId, Request $request)
	{
		$menu = array('stage','list');
		$repository_stagesub= $this->getDoctrine()->getRepository('KmcAdminBundle:StageSubscription');
		$subscriptions = $repository_stagesub->findByStage($stageId);
		return $this->render('KmcAdminBundle:Stage:StageSubscriptionList.html.twig',array('subscriptions'=>$subscriptions,'menu'=>$menu,'stageId'=>$stageId));
	}
	
	public function StageSubscriptionExtractAction($stageId)
	{
		$repository_stagesub= $this->getDoctrine()->getRepository('KmcAdminBundle:StageSubscription');
		$subscriptions = $repository_stagesub->findByStage($stageId);
		$response = $this->render('KmcAdminBundle:Stage:StageSubscriptionExtract.html.twig',array('subscriptions'=>$subscriptions));
		
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Disposition', 'attachment; filename="souscription.csv"');
		
		return $response;
	}
	
	public function DeleteStageAction ($stageId)
	{
		$repository_stagesub= $this->getDoctrine()->getRepository('KmcAdminBundle:Stage');
		$stage = $repository_stagesub->findByStage($stageId);
		if(empty($stage))
		{
			
		}
	}
}