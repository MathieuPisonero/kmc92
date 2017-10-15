<?php 

namespace Kmc\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Kmc\Bundle\UserBundle\Form\AssociationType;
use Kmc\Bundle\UserBundle\Entity\Association;


class AssociationController extends Controller
{
	public function GetAjaxFormAction($id)
	{
		//$associations= $user->getAssociations();
		$association = new Association();
		if($id)
		{
			$repository= $this->getDoctrine()->getRepository('KmcUserBundle:Association');
			$association= $repository->find($id);
		}
		
		$form_association = $this->createForm(AssociationType::class, $association);
		return $this->render('@KmcUserBundle/Profile/Association/association_form.html.twig', array(
				'form_association' => $form_association->createView()
		));
	}
}
