<?php

namespace Kmc\Bundle\KmcBundle\Controller;

use Kmc\Bundle\KmcBundle\Form\Type\SubscriptionFormType;
use Kmc\Bundle\KmcBundle\Form\Type\PaymentFormType;
use Kmc\Bundle\KmcBundle\Form\Type\SubscriptionInformationsFormType;
use Kmc\Bundle\KmcBundle\Form\Type\Season;
use Kmc\Bundle\KmcBundle\Entity\Subscription;
use Kmc\Bundle\KmcBundle\Entity\club;
use Kmc\Bundle\KmcBundle\Entity\InformationSubscription;

use Kmc\Bundle\KmcBundle\Entity\InformationQuestion;
use Kmc\Bundle\KmcBundle\Entity\InformationAnswer;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SubscriptionController extends Controller
{
    public function step1Action(Request $request)
    {
    	$helper = $this->get("kmc_kmc.imageloader");
    	$em = $this->getDoctrine()->getManager();
    	$date = date('Y/m/d 00:00:00');
    	$query = $em->createQuery("SELECT u.name FROM KmcKmcBundle:Season u WHERE u.seasonstart < '" . $date . "' AND u.seasonend > '" . $date ."'");
    	$results = $query->getResult();
    	
    	if(!count($results))
    	{
    		return $this->render('KmcKmcBundle:Subscription:nosubscription.html.twig');
    	}
        //recuperationd de la session
        $session = $request->getSession();
        
        //$session->remove('subscription');
        //$session->remove('new_menber_step');
        //$session->remove('price');
		
        $subscription = new Subscription();
        
        $step = $session->get('new_menber_step');
        //Recuperation des info en session si l'etape 1 à déja était enregistrée.
        if( $step == 1)
        {
            $subscription = $session->get('subscription');
            $certificat = $request->getSession()->get('subscription')->getCertificat();
            
        }
        
        $form = $this->createForm(SubscriptionFormType::class, $subscription);
        $form->handleRequest($request);
        if ($form->isValid()) {
        	
        	if(empty($subscription->getCertificat()) && !empty($certificat))
        		$subscription->setCertificat($certificat);
        	else
        		$subscription = $helper->setFileName($subscription,$request);
            $em->detach($subscription);
            $session->set('subscription',$subscription);
            $session->set('new_menber_step',1);
            return $this->redirect($this->generateUrl('kmc_subscription_step2'));
        }
        return $this->render('KmcKmcBundle:Subscription:step1.html.twig',array('form'=>$form->createView(),'certificat_img'=>$helper->isTmpCertificat($subscription)));
    }

    public function step2Action(Request $request)
    {
        $session = $request->getSession();
        
        $price=$session->get('price');
        if( $session->get('new_menber_step') != 1 )
            return $this->redirect($this->generateUrl('kmc_subscription_step1'));
        $subscription = $session->get('subscription');
        if($subscription->getPayment())
        {
            $repository_Payment = $this->getDoctrine()
                                        ->getRepository('KmcKmcBundle:Payment');
            $payment = $repository_Payment->find($subscription->getPayment()->getId());
            $subscription->setPayment($payment);
        }

        if($subscription->getPrice())
        {
            $repository_Price = $this->getDoctrine()
                                     ->getRepository('KmcKmcBundle:Price');
            $price = $repository_Price->find($subscription->getPrice()->getId());
            $subscription->setPrice($price);
        }
        //var_dump($subscription->getCertificat());die();
        $form = $this->createForm(PaymentFormType::class, $subscription);
        if( date("n") > 3 && date("n") <06)
        {
            $price=$session->get('price');
            $price=array($price['half'],'half');
        }
        else{
            $price=$session->get('price');
            $price=array($price['complete'],'complete');
        }
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->detach($subscription);
            $session->set('subscription',$subscription);
            $session->set('new_menber_step',1);
            return $this->redirect($this->generateUrl('kmc_subscription_step3'));
        }
       return $this->render('KmcKmcBundle:Subscription:step2.html.twig',array('form'=>$form->createView(),'price'=>$price));

    }

    public function step3Action(Request $request)
    {
        $session = $request->getSession();
        if( $session->get('new_menber_step') != 1 )
            return $this->redirect($this->generateUrl('kmc_subscription_step1'));

        //Recuperation des informations de session
        $subscription = $session->get('subscription');

        $em = $this->getDoctrine()->getManager();
        $subscription->setMajor(1);



        //Mise en place des questtion
        $repository_Question = $this->getDoctrine()
                                    ->getRepository('KmcKmcBundle:InformationQuestion');
       	//$questions = $repository_Question->findAll();
       	$query = $repository_Question->createQueryBuilder('p')
       									 ->where('p.active = 1')
        								 ->getQuery();
       	$questions = $query->getResult();
        $count = count($questions)-1;
        if(!count($subscription->getInformations()))
        {
            foreach($questions as $question)
            {
                    $information_subscription = new InformationSubscription();
                    $information_subscription->setQuestion($question);
                    $subscription->addInformation($information_subscription);
            }
        }else{

            $infos = $subscription->getInformations();
            foreach($infos as $info)
            {
                $id = $info->getQuestion()->getId();
                $q = $repository_Question->find($id);
                $info->setQuestion($q);
                if($info->getAnswer())
                {
                    $id = $info->getAnswer()->getId();
                    $repository_Answer = $this->getDoctrine()
                                              ->getRepository('KmcKmcBundle:InformationAnswer');
                    $a = $repository_Answer->find($id);
                    $info->setAnswer($a);
                }
            }
        }

        //Mise en place d'un tableau pour affihcer les champs custols... bof
        $query = $em->createQuery('SELECT u.id as article_id FROM KmcKmcBundle:InformationAnswer u WHERE u.custom=1');
        $results = $query->getResult();
        $customAnswer = $results;

        //Gestion du formulaire
        $form = $this->createForm(SubscriptionInformationsFormType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $session->set('subscription',$subscription);
            return $this->redirect($this->generateUrl('kmc_subscription_step4'));

        }
        return $this->render('KmcKmcBundle:Subscription:step3.html.twig',array('form'=>$form->createView(), 'customAnswer'=>$customAnswer,'count'=>$count));
    }

    function step4Action(Request $request)
    {
        $session = $request->getSession();
        if( $session->get('new_menber_step') != 1 )
            return $this->redirect($this->generateUrl('kmc_subscription_step1'));

        $subscription = $session->get('subscription');

        //Recuperation du club
        $repository_city = $this->getDoctrine()->getRepository('KmcKmcBundle:City');
        $city = $repository_city->findByZipcode($subscription->getZipcode());
        if(count($city))
            $club = $city[0]->getClub();
        else{
            $repository_club = $this->getDoctrine()->getRepository('KmcKmcBundle:Club');
            $club = $repository_club->find(24);
        }

         $em = $this->getDoctrine()->getManager();
         $subscription->setMajor(1);

         $repository_Question = $this->getDoctrine()
                                     ->getRepository('KmcKmcBundle:InformationQuestion');

         //recuperation des entité d'information persisté
          $infos = $subscription->getInformations();
          foreach($infos as $info)
          {
              $id = $info->getQuestion()->getId();
              $q = $repository_Question->find($id);
              $info->setQuestion($q);
              if($info->getAnswer())
              {
                  $id = $info->getAnswer()->getId();
                  $repository_Answer = $this->getDoctrine()
                      ->getRepository('KmcKmcBundle:InformationAnswer');
                  $a = $repository_Answer->find($id);
                  $info->setAnswer($a);
              }
          }


          //recuperation des entité de paiment persisté
          $repository_Payment = $this->getDoctrine()
                                      ->getRepository('KmcKmcBundle:Payment');
          $payment = $repository_Payment->find($subscription->getPayment()->getId());
          $subscription->setPayment($payment);

          //recuperation des entité de tarid persisté
          $repository_Price = $this->getDoctrine()
              ->getRepository('KmcKmcBundle:Price');
          $price = $repository_Price->find($subscription->getPrice()->getId());
          $subscription->setPrice($price);

          $price_val  = $price->getPrice();
          $paymentNum = $payment->getNumberpayment();
          $tabPrice = array();
          if($paymentNum != 1)
          {
              $unit = ceil ($price_val/$paymentNum);
              $last = $price_val-($unit*($paymentNum-1));

              if($unit == $last)
              {
                  $tabPrice[] = array('total'=>$price_val,'num'=>$paymentNum,'val'=>$unit);
              }else
              {
                  $tabPrice[] = array('total'=>$price_val,'num'=>$paymentNum-1,'val'=>$unit);
                  $tabPrice[] = array('total'=>$price_val,'num'=>1,'val'=>$last);
              }
          }else
          {
              $tabPrice[] = array('total'=>$price_val,'num'=>1,'val'=>$price_val);
          }

          //determine si l'inscrit est majeur ou mineur
          $birthdate = date("d/m/Y",strtotime($subscription->getBirthdate()->date));
          $time = strtotime($subscription->getBirthdate()->date);
          $timeImp = mktime(0, 0, 0, date("m")  , date("d"), date("Y")-15);
          $timeAuth = mktime(0, 0, 0, date("m")  , date("d"), date("Y")-18);

          if($time > 0)
          {
              if( ($time > $timeAuth) ){
                  $subscription->setMajor(0);
              }else{
                  $subscription->setMajor(1);
              }
          }

          $form = $this->createFormBuilder($subscription)
              ->add('next_step', SubmitType::class,array('label'=>'Finaliser l\'inscription'))
              ->getForm();



          $form->handleRequest($request);
          if ($form->get('next_step')->isClicked()){
			
 			  //fixe la saison
	          //Recuperation de la saison
	          $repository_season = $this->getDoctrine()
	          							  ->getRepository('KmcKmcBundle:Season');
	          $season = $repository_season->find(5);
	          $subscription->setCreated (new \DateTime('now',new \DateTimeZone('EUROPE/Paris')));
	          $subscription->setSeason($season);
	          $subscription->setIsconvert(0);
              //Fixe le club
              $subscription->setClub($club);
              $helper = $this->get("kmc_kmc.imageloader");
              
              $subscription = $helper->saveCertificat($subscription);
              $em->persist($subscription);
              $em->flush();
              
              //generation inscription club
              $html = $this->render('KmcKmcBundle:Subscription:subscription_pdf.html.twig',array('subscription'=>$subscription,
                                                                                            'birthdate'=>$birthdate,
                                                                                            'tabPrice'=>$tabPrice,
                                                                                            'season'=>$session->get('season')));
              $data = $this->get('knp_snappy.pdf')->getOutputFromHtml($html->getContent());
              
              $fs = new Filesystem();
              $filename = $subscription->getFirstname() . '_' . $subscription->getlastname() . '_fiche_inscription.pdf';
              $fs->dumpFile('docs/' . $filename, $data);
              
              //generation demande licence
              $html = $this->render('KmcKmcBundle:Subscription:fekm_pdf.html.twig',array('subscription'=>$subscription,
                                                                                                  'birthdate'=>$birthdate,
                                                                                                  'season'=>$session->get('season')));
              $data = $this->get('knp_snappy.pdf')->getOutputFromHtml($html->getContent());
              
              $fs = new Filesystem();
              $filename_licence = $subscription->getFirstname() . '_' . $subscription->getlastname() . '_licence.pdf';
              $fs->dumpFile('docs/' . $filename_licence, $data);
              $message = \Swift_Message::newInstance()
                          ->setSubject('Confirmation de votre pré-inscription de la saison 2015-2016 sur KMC92.fr')
                          ->setFrom('noreply.kmc92@gmail.com')
                          ->setTo($subscription->getEmail())
                          ->setBody($this->render('KmcKmcBundle:Subscription:subscription_mail.html.twig',array('firstname'=>$subscription->getFirstname()))->getContent(),'text/html')
                          ->attach(\Swift_Attachment::fromPath('docs/' . $filename))
                          ->attach(\Swift_Attachment::fromPath('docs/' . $filename_licence));
              $this->get('mailer')->send($message);
              //$fs->remove('docs/' . $filename);
              //$fs->remove('docs/' . $filename_licence);
              $session->remove('subscription');
              $session->remove('new_menber_step');
              return $this->render('KmcKmcBundle:Subscription:confirm.html.twig');
          }
        //return $this->render('KmcKmcBundle:Subscription:test.html.twig');

        return $this->render('KmcKmcBundle:Subscription:step4.html.twig',array('form' => $form->createView(), 'subscription'=>$subscription,'club'=>$club,'birthdate'=>$birthdate,'price'=>$price,'tabPrice'=>$tabPrice));
    }
}
