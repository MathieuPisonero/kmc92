<?php 
// src/AppBundle/Twig/AppExtension.php

namespace Kmc\Bundle\AdminBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;


class ImageAliasExtension extends \Twig_Extension
{
	protected $container, $user, $isAuthenticated;
	
	public function __construct(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('image_alias', array($this, 'imageAliasFilter')),
        );
    }

    public function imageAliasFilter($association, $context)
    {
    	$helper = $this->container->get("kmc_admin.content.download");
    	$url = $helper->getUrlImageAlias($association, $context);
        return $url;
    }
}