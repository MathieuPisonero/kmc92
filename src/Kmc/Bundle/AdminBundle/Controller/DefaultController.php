<?php

namespace Kmc\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $menu = array('subscription','price');
        return $this->render('KmcAdminBundle:Default:index.html.twig', array('name' => $name,'menu'=>$menu));
    }
}
