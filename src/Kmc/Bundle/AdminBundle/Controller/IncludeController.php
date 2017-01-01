<?php

namespace Kmc\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IncludeController extends Controller
{
    public function MenuAction($menu)
    {
        return $this->render('KmcAdminBundle:Include:menu.html.twig',array('menu'=>$menu));
    }
}
