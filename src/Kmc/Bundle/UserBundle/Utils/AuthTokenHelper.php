<?php 

namespace Kmc\Bundle\UserBundle\Utils;

use Kmc\Bundle\UserBundle\Entity\AuthToken;
use Kmc\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Kmc\Bundle\UserBundle\Security\AuthTokenAuthenticator;

class AuthTokenHelper
{
	
	private $container;
	
	private $em;
	const TOKEN_VALIDITY_DURATION = 1 * 3600;
	
	public function __construct(ContainerInterface $container, EntityManager $em)
	{
		$this->container = $container;
		$this->em = $em;
	}
	
	public function CheckUserToken($user, Request $request)
	{
		
		if(empty ($user) || !($user instanceof User))
			return false;
		
		$tokenRepo = $this->em->getRepository("Kmc\Bundle\UserBundle\Entity\AuthToken");
		$authToken= $tokenRepo->findOneBy(array(
						"user" => $user));
		
		if($authToken instanceof AuthToken && $this->checkTokenValidity($authToken))
				return $authToken->getValue();
		
		$this->removeTokens($user);
		return false;
		
	}
	
	public function CreateToken($user, Request $request)
	{
		if(empty ($user) || !($user instanceof User))
			return false;
		$authToken = new AuthToken();
		$authToken->setValue(base64_encode(random_bytes(50)));
		$authToken->setCreatedAt(new \DateTime('now'));
		$authToken->setUser($user);
		
		$this->em->persist($authToken);
		$this->em->flush();
		return $authToken->getValue();
		
	}
	
	private function checkTokenValidity($authToken)
	{
		return (time() - $authToken->getCreatedAt()->getTimestamp()) < self::TOKEN_VALIDITY_DURATION;
	}
	
	public function removeTokens($user)
	{
		$tokenRepo = $this->em->getRepository("Kmc\Bundle\UserBundle\Entity\AuthToken");
		$tokenRepo->removeTokens($user);
	}
}
?>