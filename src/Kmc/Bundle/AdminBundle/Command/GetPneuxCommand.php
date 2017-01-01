<?php 
// src/AppBundle/Command/GreetCommand.php

namespace Kmc\Bundle\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class GetPneuxCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('admin:getpneux')
            ->setDescription('Greet someone')
            ->addArgument('start', InputArgument::OPTIONAL, 'start.', 0)
            ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$result = array();
    	$options =array(7.25,12,13,14,30,31,32,33,35,37,105,125,135,145,155,165,175,180,185,195,205,210,215,220,225,235,245,255,265,275,285,295,305,315,325,335,345,355,500,550,640,650,670,700,750);	
    	 
    	foreach ($options as $option)
    	{
    		$dom = new \DOMDocument;
    		$handle = file_get_contents("http://www.allopneus.com/find?activite=1&d1=".$option);
    		$dom->loadHTML($handle);
    		$trs = $dom->getElementsByTagName('tr');
    		foreach ($trs as $tr) {
    			if($tr->getAttributeNode("data-dim"))
    			{
    				$tds = $tr->getElementsByTagName('td');
    				foreach($tds as $td)
    				{
    					if($td->getAttributeNode('class')->value == "pack_commercial_prix")
    					{
    						$spans = $td->getElementsByTagName('span');
    						foreach($spans as $span)
    						{
    							if($span->getAttributeNode('class')->value == "tarif_home_ttc" || $span->getAttributeNode('class')->value == "tarif_home_ttc bb")
    							{
    								$split = split(' ', trim($span->nodeValue));
    								$price =  str_replace(",", ".", $split[0]);
    								
    								$result[]=array($tr->getAttributeNode("data-dim")->value,floatval($price));
    							}
    						}
    					}
    				}
    			}
    		}
    	}
    	$prices = array();
    	foreach ($result as $r)
    	{
    		$price = $r[1];
    		if(array_key_exists($r[0],$prices))
    		{
    			$price= ($prices[$r[0]][1]+$r[1])/2;
    		}
    		$prices[$r[0]] = array($r[0],$price);
    	}
    	$fp = fopen('/home/kmc/www/web/pneux.csv', 'w');
    	foreach ($prices as $ref=>$price)
    	{
    		fputcsv($fp, $price);
    	}
    	
    }
}
