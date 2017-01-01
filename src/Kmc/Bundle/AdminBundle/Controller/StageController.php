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
		return $this->render('KmcAdminBundle:Stage:List.html.twig',array('menu'=>$menu,'stages'=>$stages));
	}
	
	public function EditAction($stageId)
	{
		$menu = array('stage','list');
		$repository_stage= $this->getDoctrine()
							   ->getRepository('KmcAdminBundle:Stage');
		$stage = $repository_stage->find($stageId);
		$form = $this->createForm(new StageFormType(), $stage);
		return $this->render('KmcAdminBundle:Stage:Edit.html.twig',array('menu'=>$menu,'stage'=>$stage,'form'=>$form->createView()));
	}
	
	public function NewAction(Request $request)
	{
		$menu = array('stage','new');
		$stage = new Stage();
		$form = $this->createForm(new StageFormType(), $stage);
		$form->handleRequest($request);
		if ($form->isValid()) {
			$repository= $this->getDoctrine()->getRepository('KmcAdminBundle:Stage');
			$key = $repository->GenKey($stage->getName());
			
			$stage->setUrlKey($key);
			$image = $request->files->get('image_club');
			if(!empty($image))
			{
				$image->move('/home/kmc/www/web/img_stage', $image->getClientOriginalName());
				$path = '/img_stage/'.$image->getClientOriginalName();
				$stage->setImg($path);
			}
			$em = $this->getDoctrine()->getManager();
			$em->persist($stage);
			$em->flush();
			return $this->redirect($this->generateUrl('kmc_admin_stage_edit',array('stageId' => $stage->getId())));
		}
		return $this->render('KmcAdminBundle:Stage:New.html.twig',array('menu'=>$menu, 'form'=>$form->createView()));
	}
}