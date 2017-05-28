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


class AdminController extends Controller
{
	
	public function IndexAction()
	{
		$menu = array('home','');
		return $this->render('KmcAdminBundle:Admin:Index.html.twig',array('menu'=>$menu));
	}
	
	
	
	/***********************/
	/* Gestion des saisons */
	/***********************/
    public function SeasonAction(Request $request)
    {
    	$menu = array('Season','config');
        $repository_season= $this->getDoctrine()
                                    ->getRepository('KmcKmcBundle:Season');
        $seasons = $repository_season->findAll();
        return $this->render('KmcAdminBundle:Admin:Season.html.twig',array('seasons'=>$seasons,'menu'=>$menu));
    }
    
    public function SeasonEditAction($id, Request $request)
    {
    	$menu = array('Season','config');
    	$val = false;
    	$err =false;
    	$repository_season= $this->getDoctrine()
    	->getRepository('KmcKmcBundle:Season');
    	$seasons = $repository_season->findById($id);
    	$season = $seasons[0];
    	$form = $this->createForm(SeasonFormType::class, $season);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$val = true;
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($season);
    		$em->flush();
    	}
    	return $this->render('KmcAdminBundle:Admin:SeasonEdit.html.twig',array('form'=>$form->createView(),'val'=>$val, 'err'=>$err,'menu'=>$menu));
    }
    
    public function SeasonNewAction(Request $request)
    {
    	$menu = array('Season','config');
    	$season = new Season();
    	$form = $this->createForm(SeasonFormType::class, $season);
    	$form->handleRequest($request);
    	$val=false;
    	$err =false;
    	if ($form->isValid()) {
    		$date = $season->getSeasonstart()->format('Y/m/d h:m:s');
    		$date_end = $season->getSeasonend()->format('Y/m/d h:m:s');
    		$em = $this->getDoctrine()->getManager();
    		if(strtotime ($date) >= strtotime($date_end))
    		{
    			$err = 1;
    		}
    		if(!$err)
    		{
    			$query = $em->createQuery("SELECT u.name FROM KmcKmcBundle:Season u WHERE u.seasonend > '" . $date ."'");
    			$results = $query->getResult();
	    		if(count($results))
	    		{
	    			$err = 2;
	    		}
    		}
    		
    		if(!$err)
    		{
    			$em->persist($season);
    			$em->flush();
    			return $this->redirect($this->generateUrl('kmc_admin_season'));
    		}
    	}
    	return $this->render('KmcAdminBundle:Admin:SeasonEdit.html.twig',array('form'=>$form->createView(),'err'=>$err,'val'=>$val, 'menu'=>$menu));
    }

    
    
    /**********************/
    /* Gestion des tarifs */
    /**********************/
    public function PriceNewAction($id, Request $request)
    {
    	$menu = array('Season','price');
    	$price = new Price();
    	$val = false;
    	$type = 'new';
    	if($id)
    	{
    		$repository_price= $this->getDoctrine()->getRepository('KmcKmcBundle:Price');
    		$price = $repository_price->findOneById($id);
    		$type='edit';
    	}
    	$form = $this->createForm(PriceFormType::class, $price);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$val = true;
    		$price->setActive(0);
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($price);
    		$em->flush();
    	}
    	return $this->render('KmcAdminBundle:Admin:PriceNew.html.twig',array('menu'=>$menu,'form'=>$form->createView(),'val'=>$val,'type'=>$type));
    }
    
    
    public function PriceAction(Request $request)
    {
    	$menu = array('Season','price');
    	$modif=false;
    	$active_id = $request->request->get('active_id');
    	if( !empty($active_id) )
    	{
    		$em = $this->getDoctrine()->getManager();
    		$query = $em->createQuery('UPDATE KmcKmcBundle:Price p SET p.active = 0');
    		$query->getResult();
    		$in ="";
    		$query = $em->createQuery('UPDATE KmcKmcBundle:Price p SET p.active = 1 WHERE p.id IN('.implode(",", $active_id).')');
    		$query->getResult();
    		$modif=true;
    	}
    	$repository_price= $this->getDoctrine()
    					        ->getRepository('KmcKmcBundle:Price');
    	$prices = $repository_price->findAll();
    	$forms=array();
    	foreach($prices as $price){
    		$form = $this->createForm(PriceFormType::class, $price);
    		$forms[$price->getId()]=array($price->getId(),$form->createView(),$form);
    	}
    	
    	foreach($prices as $price){
    		$price_form_submit_id = $request->request->get('tarif_id');
    		if($price_form_submit_id != $price->getId())
    			continue;
    		$frm = $forms[$price->getId()][2];
	    	$frm->handleRequest($request);
	    	if ($frm->isValid()) {
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($price);
	    		$em->flush();
	    		$modif = true;
	    	}
    	}
    	foreach($prices as $price){
    		$form = $this->createForm(PriceFormType::class, $price);
    		$forms[$price->getId()]=array($price->getId(),$form->createView(),$form);
    	}
    	
    	return $this->render('KmcAdminBundle:Admin:Price.html.twig',array('prices'=>$prices,'menu'=>$menu,'forms'=>$forms, 'modif'=>$modif));
    }
    
    /************************************/
    /* Gestion des listes d'inscription */
    /************************************/
    public function SubscriptionListAction(Request $request)
    {
    	$season = $request->query->get('season');
    	echo count($season);
        if(empty($season))
        	$season=5;
    	$menu = array('subscriptionlist','');
        $repository_season= $this->getDoctrine()
                                 ->getRepository('KmcKmcBundle:Subscription');
       $query = $repository_season->createQueryBuilder('p')
        			 ->where('p.season = :season AND p.isconvert = :isconvert')
        			 ->setParameter('season', $season)
        			 ->setParameter('isconvert', 0)
        			 ->getQuery();
       $subscriptions = $query->getResult();
       //$subscriptions = $repository_season->findAll();
        return $this->render('KmcAdminBundle:Admin:SubscriptionList.html.twig',array('menu'=>$menu,'subscriptions'=>$subscriptions,'season'=>$season));
    }
    
    public function SubscriptionCSVListAction($season)
    {
        $menu = array('subscriptionlist','');
        $repository_season= $this->getDoctrine()->getRepository('KmcKmcBundle:Subscription');
        $query = $repository_season->createQueryBuilder('p')
        			 ->where('p.season = :season')
        			 ->setParameter('season', $season)
        			 ->getQuery();
        $subscriptions = $query->getResult();
        $response = $this->render('KmcAdminBundle:Admin:SubscriptionCSVList.html.twig',array('menu'=>$menu,'subscriptions'=>$subscriptions));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="souscription.csv"');

        return $response;
    }
    
    
    
    /*******************************************/
    /* Conversion d'une inscription en membres */
    /*******************************************/
    public function ConvertToMenberAction (Request $request, $subscription_id)
    {
    	$menu = array('club','');
    	$subscritpion= $this->getDoctrine()
    					  ->getRepository('KmcKmcBundle:Subscription')
    					  ->find($subscription_id);
    	$repository_member= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
    	$member_exist = $repository_member->findOneBy(array('email' => $subscritpion->getEmail()));
   		$is_member = false;
   		$member = new Member();
    	if($member_exist)
    		$is_member = true;
    	$createCard = $request->query->get('createCard');
    	if(empty($createCard))
    	{	
	    	$member->setCivility($subscritpion->getCivility());
	    	$member->setLastname($subscritpion->getLastname());
	    	$member->setFirstname($subscritpion->getFirstname());
	    	$member->setEmail($subscritpion->getEmail());
	    	$member->setPhone($subscritpion->getPhone());
	    	$member->setJob($subscritpion->getJob());
	    	$member->setBirthdate($subscritpion->getBirthdate());
	    	$member->setAdress($subscritpion->getAdress());
	    	$member->setZipcode($subscritpion->getZipcode());
	    	$member->setCity($subscritpion->getCity());
	    	$member->setMajor($subscritpion->getMajor());
	    	$member->setResponsablefirstname($subscritpion->getResponsablefirstname());
	    	$member->setResponsablelastname($subscritpion->getResponsablelastname());
	    	$member->setPracticeyear($subscritpion->getPracticeyear());
	    	$member->setPraticelevel($subscritpion->getPracticelevel());
    	}
    	$form = $this->createForm(MemberFormType::class, $member);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$member->setClub($subscritpion->getClub());
    		if($member_exist)
    		{
    			$member_exist->setCivility($member->getCivility());
    			$member_exist->setLastname($member->getLastname());
    			$member_exist->setFirstname($member->getFirstname());
    			$member_exist->setEmail($member->getEmail());
    			$member_exist->setPhone($member->getPhone());
    			$member_exist->setJob($member->getJob());
    			$member_exist->setBirthdate($member->getBirthdate());
    			$member_exist->setAdress($member->getAdress());
    			$member_exist->setZipcode($member->getZipcode());
    			$member_exist->setCity($member->getCity());
    			$member_exist->setMajor($member->getMajor());
    			$member_exist->setResponsablefirstname($member->getResponsablefirstname());
    			$member_exist->setResponsablelastname($member->getResponsablelastname());
    			$member_exist->setPracticeyear($member->getPracticeyear());
    			$member_exist->setPraticelevel($member->getPraticelevel());
    			$member_exist->setClub($member->getClub());
    			$member = $member_exist;
    		}
 
    		$MemberSeason = new MemberSeason();
    		$MemberSeason->setMember($member);
    		$MemberSeason->setSeason($subscritpion->getSeason());
    		$MemberSeason->setPrice($subscritpion->getPrice());
    		$em->persist($MemberSeason);
    		$member->addSeason($MemberSeason);

    		$em->persist($member);
    		$em->flush();
    		
    		$em = $this->getDoctrine()->getManager();
    		$query = $em->createQuery("UPDATE KmcKmcBundle:Subscription p SET p.isconvert = 1 WHERE p.season=" . $subscritpion->getSeason()->getId() . " AND p.email='" . $subscritpion->getEmail() . "'");
    		$query->getResult();
    		return $this->redirect($this->generateUrl('kmc_admin_subscriptionlist',array('convert' => true)));
    	}
    	
    	$response = $this->render('KmcAdminBundle:Admin:ConvertToMenber.html.twig',array('menu'=>$menu,'member_exist'=>$member_exist,'is_member'=>$is_member, 'form'=>$form->createView()));
    	return $response;
    }
    
    
    /***********************/
    /* Gestion des membres */
    /***********************/
    public function MemberCardAction($member_id)
    {
    	$repository_member= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
    	$member = $repository_member->find($member_id);
    	
    	return $this->render('KmcAdminBundle:Admin:MemberCard.html.twig',array('member'=>$member));
    }
    
    public function MemberListCardAction(Request $request)
    {
    	$menu = array('member','list');
    	$array = array("season"=>"all","level"=>"all",'minor'=>false);
    	$filter = $request->request->get('filter');
    	if(!empty($filter))
    	{
    		$array['season']= $request->request->get('season');
    		$array['level']= $request->request->get('level');
    		$minor = $request->request->get('minor');
    		if(!empty($minor))
    			$array['minor']= true;
    	}
    	$repository_member= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
    	//var_dump(count($repository_member->findAll()));
    	
    	$repository_season= $this->getDoctrine()->getRepository('KmcKmcBundle:Season');
    	$seasons = $repository_season->findAll();
    	
    	//die();
    	$members = $repository_member->findAllFilter($array);
    	return $this->render('KmcAdminBundle:Admin:MemberCardList.html.twig',array('menu'=>$menu,'members'=>$members,'seasons'=>$seasons,'filter'=>$array));
    }
    
    public function MemberExportListAction($season_id, $grade_id, $minor)
    {
    	if($minor == "false")
    		$minor = false;
    	else
    		$minor =true;
    	$array = array("season"=>$season_id,"level"=>$grade_id,'minor'=>$minor);
    	$repository_member= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
    	$members = $repository_member->findAllFilter($array);
    	
    	$response = $this->render('KmcAdminBundle:Admin:MemberCSVList.html.twig',array('members'=>$members));
    	$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment; filename="souscription.csv"');
    	return $response;
    }
    
    public function MemberEditCardAction(Request $request, $member_id)
    {
    	$menu = array('member','list');
    	
    	
    	$validation =false;
    	if($request->query->get('created'))
    	{
    		$validation = "Le membre a bien été créé";
    	}
    	$repository_member= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
    	$member = $repository_member->find($member_id);
    	
    	$supp_season_action = $request->request->get('supp_season_action');
    	
    	if(!empty ($supp_season_action))
    	{
    		$supp_seasons = $request->request->get('supp_seasons');
    		if(!empty($supp_seasons))
    		{
    			foreach($supp_seasons as $season)
    			{
    				$repository_season= $this->getDoctrine()->getRepository('KmcAdminBundle:MemberSeason');
    				$sea = $repository_season->find($season);
    				$member->removeSeason($sea);
    				$em = $this->getDoctrine()->getManager();
	    			$em->remove($sea);
        			$em->flush();
        			$validation = "La saison a été supprimée";
    			}
    		}
    		
    	}
    	
    	$form = $this->createForm(MemberFormType::class, $member);
    	$memberSeason = new MemberSeason();
    	$form_season = '';
    	$form_season = $this->createForm(MemberSeasonFormType::class, $memberSeason);
    	
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$var_minor = $request->request->get('major');
    		if($var_minor != "minor15")
    		{
    			if($var_minor == "minor")
    				$member->setMajor(0);
    			else
    				$member->setMajor(1);
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($member);
    			$em->flush();
    			$validation = "Le membre a été mis à jour";
    		}
    	}
    	$form_season->handleRequest($request);
    	if ($form_season->isValid()) {
    		$seasonexist= false;
    		foreach($member->getSeasons() as $season)
    		{
    			if($season->getSeason()->getId() == $memberSeason->getSeason()->getId())
    			{
    				$seasonexist = true;
    				break;
    			}
    			
    		}
    		if(!$seasonexist)
    		{
	    		$member->addSeason($memberSeason);
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($member);
	    		$em->flush();
	    		$validation = "La saison a été ajoutée";
    		}
    	}
    	$response =  $this->render('KmcAdminBundle:Admin:MemberEditCard.html.twig',array('menu'=>$menu,'seasons'=>$member->getSeasons(),'form'=>$form->createView(),'form_season'=>$form_season->createView(),'validation'=>$validation));
    	return $response;
    }
    
    public function MemberNewCardAction(Request $request)
    {
    	$menu = array('member','card');
    	$memberseason = new MemberSeason();
    	$member = new Member ();
    	$member->addSeason($memberseason);
    	$form = $this->createForm(NewMemberFormType::class, $member);
    	$form->handleRequest($request);
    	if($form->isValid())
    	{
    		$var_minor = $request->request->get('major');
    		if($var_minor != "minor15")
    		{
		    		if($var_minor == "minor")
		    			$member->setMajor(0);
		    		else 
		    			$member->setMajor(1);
    				$em = $this->getDoctrine()->getManager();
		    		$em->persist($member);
		    		$em->flush();
		    		return $this->redirect($this->generateUrl('kmc_admin_member_edit_card',array('member_id' => $member->getId(),'created'=>true)));
    		}
    	}
    	$response =  $this->render('KmcAdminBundle:Admin:MemberNewCard.html.twig',array('menu'=>$menu,'form'=>$form->createView()));
    	return $response;
    }
    
    public function MemberFactureAction($member_id,$season_id)
    {
    	$repository_member= $this->getDoctrine()->getRepository('KmcAdminBundle:Member');
    	$member = $repository_member->find($member_id);
    	$season = $member->findSeasonById($season_id);
    	$html=  $this->render('KmcAdminBundle:Admin:MemberFacture.html.twig',array('member'=>$member,'season'=>$season));
    	return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html->getContent()), 200, array(
        																			'Content-Type'=> 'application/pdf',
        																			'Content-Disposition'   => 'attachment; filename="file.pdf"'
																				  ));	
    }
    
    
    /*********************/
    /* Gestion des clubs */
    /*********************/
    public function ClubListAction()
    {
        $menu = array('club','');
        $repository_club= $this->getDoctrine()
                                ->getRepository('KmcKmcBundle:Club');
        $clubs = $repository_club->findAll();
        $response =  $this->render('KmcAdminBundle:Admin:ClubList.html.twig',array('menu'=>$menu,'clubs'=>$clubs));
        return $response;
    }

    public function ClubEditAction(Request $request, $id)
    {
        $menu = array('club','');
        $edit = false;
        $repository_club= $this->getDoctrine()
                               ->getRepository('KmcKmcBundle:Club');
        $club = $repository_club->find($id);

        $form = $this->createForm(ClubFormType::class, $club);
        $form->handleRequest($request);
        if ($form->isValid()) {
        	$edit = true;
        	$image = $request->files->get('image_club');
        	if(!empty($image))
        	{
        		$image->move('/home/kmc/www/web/logos', $image->getClientOriginalName());
        		$path = 'logos/'.$image->getClientOriginalName();
        		$club->setImage($path);
        	}
        	$em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
        }
        
        $city_ids = $request->request->get('city_id');
        if( !empty($city_ids) )
        {
        	$em = $this->getDoctrine()->getManager();
        	$repository_city= $this->getDoctrine()
        						   ->getRepository('KmcKmcBundle:City');
        	
        	foreach ($city_ids as $city_id)
        	{
        		$city = $repository_city->find($city_id);
        		$em->remove($city);
        		$em->flush();
        	}
        	
        }
        
		$createCity = $request->request->get('createCity');
		if( !empty($createCity) )
		{
			$em = $this->getDoctrine()->getManager();
			$repository_city= $this->getDoctrine()
								   ->getRepository('KmcKmcBundle:City');
			$city = new City();
			$city->setClub($club);
			$city->setName($request->request->get('city_name'));
			$city->setZipcode($request->request->get('city_code'));
			$em->persist($city);
			$em->flush();
			
		}
        return $this->render('KmcAdminBundle:Admin:ClubEdit.html.twig',array('menu'=>$menu,'club'=>$club,'edit'=>$edit, 'form'=>$form->createView()));
    }
    
    
    /****************************/
    /* Gestion du questionnaire */
    /****************************/
    public function informationResultAction(Request $request){
    	$menu = array('information','result');
    	$active_season_id = $request->request->get('active_seson_id');
    	if(empty($active_season_id))
    	{
    		$active_season_id = 2;
    	}
    	$repository_season= $this->getDoctrine()
                                    ->getRepository('KmcKmcBundle:Season');
        $seasons = $repository_season->findAll();
        $repository_Question= $this->getDoctrine()
        						 ->getRepository('KmcKmcBundle:InformationQuestion');
        $questions = $repository_Question->findAll();
    	
    	
    	return $this->render('KmcAdminBundle:Admin:InformationResult.html.twig',array('menu'=>$menu,'questions'=>$questions,'seasons'=>$seasons,'active_season_id'=>$active_season_id));
    }
    
    public function informationChartDataAction(Request $request, $season_id, $question_id){
    	$active_season_id = $season_id;
    	$repository_IQ= $this->getDoctrine()
    						->getRepository('KmcKmcBundle:InformationSubscription');
    	$repository_Q= $this->getDoctrine()
    						->getRepository('KmcKmcBundle:InformationQuestion');
    	$question = $repository_Q->find($question_id);
    	$result_array = array();
    		
    	$IQS = $repository_IQ->getResult($active_season_id,$question->getId());
    	
    	return new JsonResponse(array($question->getId(),$question->getText(),$IQS));
    }
    
    public function informationChartCustomDataAction(Request $request, $season_id, $question_id, $answer_id){
    	$active_season_id = $season_id;
    	$repository_IQ= $this->getDoctrine()
    	->getRepository('KmcKmcBundle:InformationSubscription');
    	$repository_Q= $this->getDoctrine()
    	->getRepository('KmcKmcBundle:InformationQuestion');
    	$question = $repository_Q->find($question_id);
    	return new JsonResponse($repository_IQ->getCustomResult($season_id, $question_id, $answer_id));
    }
    
    public function informationListAction(Request $request)
    {
    	$menu = array('information','edition');
    	//Activation/desactivation des questions
    	$active_question = $request->request->get('active_question');
    	if( !empty($active_question) )
    	{
    		$question_id = $request->request->get('question_id');
    		$em = $this->getDoctrine()->getManager();
    		$query = $em->createQuery('UPDATE KmcKmcBundle:InformationQuestion p SET p.active = 0');
    		$query->getResult();
    		$query = $em->createQuery('UPDATE KmcKmcBundle:InformationQuestion p SET p.active = 1 WHERE p.id IN('.implode(",", $question_id ).')');
    		$query->getResult();
    		$modif=true;
    	}
    	$repository_IQ= $this->getDoctrine()
    						   ->getRepository('KmcKmcBundle:InformationQuestion');
    	$IQS = $repository_IQ->findAll();
    	return $this->render('KmcAdminBundle:Admin:InformationList.html.twig',array('IQS'=>$IQS, 'menu'=>$menu));
    }
    
    public function informationNewAction(Request $request)
    {
    	$menu = array('information','edition');
    	$question = new InformationQuestion();
    	$form = $this->createForm(InformationFormType::class, $question);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$question->setActive(0);
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($question);
    		$em->flush();
    		return $this->redirect($this->generateUrl('kmc_admin_information_edit',array('id' => $question->getId())));
    	}
    	return $this->render('KmcAdminBundle:Admin:InformationNew.html.twig',array('form'=>$form->createView(), 'menu'=>$menu));
    }
    
    public function informationEditAction(Request $request,$id)
    {
    	$menu = array('information','edition');
    	$err = false;
    	$modif=false;
    	$repository_IQ= $this->getDoctrine()
    						 ->getRepository('KmcKmcBundle:InformationQuestion');
    	$IQS = $repository_IQ->find($id);
    	
    	//Activation/desactivation des questions
    	$active_answer = $request->request->get('active_answer');
    	if( !empty($active_answer) )
    	{
    		$answer_id = $request->request->get('answer_id');
    		$em = $this->getDoctrine()->getManager();
    		$query = $em->createQuery('UPDATE KmcKmcBundle:InformationAnswer p SET p.active = 0 WHERE p.informationQuestion=' . $id);
    		$query->getResult();
    		if(!empty($answer_id))
    		{
    			$query = $em->createQuery('UPDATE KmcKmcBundle:InformationAnswer p SET p.active = 1 WHERE p.informationQuestion=' . $id . ' AND p.id IN('.implode(",", $answer_id ).')');
    			$query->getResult();
    			$modif=true;
    		}
    	}
    	
    	$newInformation = new InformationAnswer();
    	$form_new_information = $this->createForm(AnswerFormType::class, $newInformation);
    	$form_new_information->handleRequest($request);
    	$new_question = $request->request->get('new_question');
    	if( !empty($new_question) )
    	{
    		if ($form_new_information->isValid()) {
    			$newInformation->setActive(1);
    			$newInformation->setInformationQuestion($IQS);
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($newInformation);
    			$em->flush();
    	
    		}
    	}
    	$newInformation = new InformationAnswer();
    	
    	
    	$answers = $IQS->getAnswers();
    	$formAnswers=array();
    	foreach($answers as $answer){
    		$formAnswer = $this->createForm(AnswerFormType::class, $answer);
    		$formAnswers[$answer->getId()]=array($answer->getId(),$formAnswer->createView(),$formAnswer);
    	}
    	
    	foreach($answers as $answer){
    		$answer_form_submit_id = $request->request->get('answer_id');
    		if($answer_form_submit_id != $answer->getId())
    			continue;
    		$frm = $formAnswers[$answer->getId()][2];
    		$frm->handleRequest($request);
    		if ($frm->isValid()) {
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($answer);
    			$em->flush();
    			$modif = true;
    			break;
    		}
    	}
    	$IQS = $repository_IQ->find($id);
    	$form = $this->createForm(InformationFormType::class, $IQS);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($IQS);
    		$em->flush();
    	}
    	foreach($answers as $answer){
    		$formAnswer = $this->createForm(AnswerFormType::class, $answer);
    		$formAnswers[$answer->getId()]=array($answer->getId(),$formAnswer->createView(),$formAnswer);
    	}

    	$form_new_information = $this->createForm(AnswerFormType::class, $newInformation);
    	
    	return $this->render('KmcAdminBundle:Admin:InformationEdit.html.twig',array('IQS'=>$IQS, 'menu'=>$menu, 'form'=>$form->createView(), 'formAnswers'=>$formAnswers, 'err'=>$err, 'modif'=>$modif, 'form_new_infomation'=>$form_new_information->createView()));
    }
}
