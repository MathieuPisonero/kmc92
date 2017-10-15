<?php

// LogoutListener.php - Change the namespace according to the location of this class in your bundle
namespace Kmc\Bundle\UserBundle\Listeners;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LogoutListener implements LogoutHandlerInterface {
    protected $userManager;
    protected $container;
    
    public function __construct(UserManagerInterface $userManager, ContainerInterface $container){
        $this->userManager = $userManager;
        $this->container = $container;
    }
    
    public function logout(Request $Request, Response $Response, TokenInterface $Token) {
    	$helper = $this->container->get("kmc.authtoken");
    	$helper->removeTokens($Token->getUser());
    }
}