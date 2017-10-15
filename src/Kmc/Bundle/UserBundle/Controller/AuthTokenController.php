<?php

namespace Kmc\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Kmc\Bundle\UserBundle\Entity\AuthToken;

class AuthTokenController extends Controller
{

    public function GetAuthTokensAction(Request $request)
    {
		$helper = $this->get("kmc.authtoken");
		
		//Check if user have already a valid token
		$authToken = $helper->CheckUserToken ($this->getUser(), $request);
	
		if($authToken)
		{
			$response = new Response(json_encode($authToken));
			return $response;
		}
		//Create new token	
		$authToken= $helper->CreateToken ($this->getUser(), $request);
		if(!$authToken)
			$response = new Response('Forbiden', Response::HTTP_UNAUTHORIZED);
		else 	
			$response = new Response(json_encode($authToken));
      
        return $response;
    }

    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }
}