<?php 

namespace Kmc\Bundle\UserBundle\Utils;

use Kmc\Bundle\UserBundle\Entity\Association;
use Kmc\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AssociationHelper
{
	
	private $container;
	
	private $em;
	
	public function __construct(ContainerInterface $container, EntityManager $em)
	{
		$this->container = $container;
		$this->em = $em;
	}
	
	public function GetUserAssociations( User $user)
	{
		$repository_association= $this->em->getRepository('KmcUserBundle:Association');
		$association_list = $repository_association->findUserList($user);
		
		$associations = array();
		//Recherche de clubs afilliés
		foreach($association_list as $association)
		{
			$tmp = null;
			if( empty($association->getParentClub()) )
			{
				$tmp = $repository_association->findUserList($user,$association);
			}
			$associations[]=array("obj"=>$association,"aff"=>$tmp);
		}
		return $associations;
	}
}
?>