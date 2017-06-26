<?php

namespace Kmc\Bundle\KmcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kmc\Bundle\KmcBundle\Form\Type\StageSubscriptionFormType;
use Kmc\Bundle\AdminBundle\Entity\StageSubscription;
use Kmc\Bundle\AdminBundle\Entity\Stage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class StageController extends Controller
{
	
	public function IndexAction(Request $request,$key_stage)
	{
		$member_email = $request->request->get('kmc_subscription_stage_member_mail');
		$err = false;
		$member_exist = false;
		$valid = false;
		
		$repository_stage= $this->getDoctrine()->getRepository('KmcAdminBundle:Stage');
		$stage = $repository_stage->findOneBy(array('urlKey' => $key_stage));
		if(empty($stage))
		{
			die('pas de stage');
		}
		
		$subscription = new StageSubscription();
		if(!empty($member_email))
		{
			$repository_stage= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
			$member = $repository_stage->findOneBy(array('email' => $member_email));
			if(empty($member))
			{
				$err = "Cette adresse mail ne correspond pas à l'adresse d'un membre";
			}else{
				$subscription->setCivility($member->getCivility());
				$subscription->setFirstname($member->getFirstname());
				$subscription->setLastname($member->getLastname());
				$subscription->setBirthdate($member->getBirthdate());
				$subscription->setPhone($member->getPhone());
				$subscription->setEmail($member->getEmail());
				$subscription->setResponsablefirstname($member->getResponsablefirstname());
				$subscription->setResponsablelastname($member->getResponsablelastname());
				$member_exist = true;
			}
		
		}
		$form = $this->createForm(StageSubscriptionFormType::class, $subscription);
		$form->handleRequest($request);
    	if ($form->isValid()) {
    		$repository_stage = $this->getDoctrine()->getRepository('KmcAdminBundle:StageSubscription');
    		$exist_subscription	 = $repository_stage->findOneBy(array('email' => $subscription->getEmail()));
    		if(empty($exist_subscription))
    		{
	    		$repository_member= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
	    		$member = $repository_member->findOneBy(array('email' => $subscription->getEmail()));
	    		if($subscription->getAge()>=18)
	    		{
	    			$subscription->setMinor(0);
	    		}else{
	    			$subscription->setMinor(1);
	    		}
	    		$subscription->setMember($member);
	    		$subscription->setStage($stage);
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($subscription);
	    		$em->flush();
	    		$valid = true;
    		}else{
    			$err= "Vous vous êtes déja inscrit à ce stage";
    		}
    		
    		
    	}
		return $this->render('KmcKmcBundle:Stage:DynamicForm.html.twig',array('stage'=>$stage, "member_exist"=>$member_exist,'form'=>$form->createView(), 'err'=>$err,'valid'=>$valid));
	}
}