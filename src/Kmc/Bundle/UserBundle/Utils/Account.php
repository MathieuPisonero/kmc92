<?php 

namespace Kmc\Bundle\UserBundle\Utils;

use Kmc\Bundle\UserBundle\Entity\Association;
use Kmc\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class Account
{
	
	private $container;
	
	private $em;
	
	public function __construct(ContainerInterface $container, EntityManager $em)
	{
		$this->container = $container;
		$this->em = $em;
	}
	
	public function saveAssociation(Association $association, User $user, Request $request)
	{
		return ($user->getId());	
	}
}
?>