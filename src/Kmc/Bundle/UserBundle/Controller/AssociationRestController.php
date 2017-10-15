<?php
namespace Kmc\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use Kmc\Bundle\UserBundle\Form\AssociationType;
use Kmc\Bundle\UserBundle\Entity\Association;

class AssociationRestController extends Controller
{
     /**
     * @Rest\View(serializerGroups={"auth-token"})
     * @Rest\Post("/api/associationrest")
     */
    public function AssociationAction(Request $request)
    {
    	$association = new Association();
    	$form = $this->createForm(AssociationType::class, $association);

    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {
    		
    		$helper = $this->get("kmc_admin.content.upload");
    		$file = $helper->getDwLFilePath($request,'club_logo');
    		if($file)
    			$association->setLogo($file);
    		$association->setUser($this->getUser());
    		$em = $this->get('doctrine.orm.entity_manager');
    		$em->persist($association);
    		$em->flush();
    		return $association;
    	}
    	return $form;
    	
    }
    
    /**
     * @Rest\View(serializerGroups={"auth-token"})
     * @Rest\Put("/api/associationrest/{id}")
     */
    public function UpdateAssociationAction(Request $request)
    {
    	//die('TREST');
    	$association = $this->get('doctrine.orm.entity_manager')
    	->getRepository('KmcUserBundle:Association')
    	->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
    	/* @var $place Place */
    	if (empty($association)) {
    		return new JsonResponse(['message' => 'Association not found'], Response::HTTP_NOT_FOUND);
    	}
    	
    	$form = $this->createForm(AssociationType::class, $association);
    	
    	// Le paramètre false dit à Symfony de garder les valeurs dans notre
    	// entité si l'utilisateur n'en fournit pas une dans sa requête
    	$form->submit($request->request->all(), false);

    	if ($form->isValid()) {
    		$helper = $this->get("kmc_admin.content.upload");
    		$file = $helper->getDwLFilePath($request,'club_logo');
    		if($file)
    			$association->setLogo($file);
    		
    		$em = $this->get('doctrine.orm.entity_manager');
    		$em->merge($association);
    		$em->flush();
    		return $association;
    	} else {
    		return($form->getErrors());
    		return $form;
    	}
    }
}