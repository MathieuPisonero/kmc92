<?php 
// src/AppBundle/Command/GreetCommand.php

namespace Kmc\Bundle\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class GetCarCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('admin:getcar')
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
    	$handle = file_get_contents("http://www.lacentrale.fr/lacote_origine.php");
    	$start =  strpos($handle,'<!-- Begin file tb_menu_marque_droite_cote.php -->');
    	$end =  strpos($handle,'<!-- End file tb_menu_marque_droite_cote.php -->');
    	$text = substr ( $handle , $start, $end - $start);
    	$test = preg_match_all("|onclick=\"AfficheListe\('(.*)\);\"|U",$text,$finds,PREG_PATTERN_ORDER );
    	$marques = array();
    	foreach($finds[1] as $find)
    	{
    		$pattern = "/','.*'/i";
    		$replacement = "";
    		$test =  preg_replace($pattern, $replacement, $find);
    		$tmp_arr = explode("|", $test);
    		$marques = array_merge($marques, $tmp_arr);
    	}
    	$output->writeln(count($marques) . 'marques trouvées');
    	/**************************
    	 * MODELE
    	 **************************/
    	foreach ($marques as $marque)
    	{
    		if($marque == "")
    			continue;
    		if($marque != "Renault")
    			continue;
    		$output->writeln("> traitement de la marque : " . $marque);
    		$url_marque = 'cote-voitures-'.strtolower($marque).'----.html';
    		$handle = file_get_contents("http://www.lacentrale.fr/" . $url_marque);
    		$start = strpos($handle,'<h1 class="CoteModeleTitre">');
    		$end = strpos($handle,'<!-- / tz_ftco_auto.php -->');
    		$text = substr ( $handle , $start, $end - $start);
    		preg_match_all("|<a href=\"(.*)\" class=\"txCouleur2\" title=\"(.*)\" >(.*)</a>|",$text,$finds,PREG_PATTERN_ORDER );
    		$types = array();
    		for ($i=0;$i<count($finds[0]); $i++)
    		{
    			$types[]=array('url'=>$finds[1][$i],"name"=>$finds[3][$i]);
    		}
    		$output->writeln(">" . count($types) . ' type de modéles trouvés');
    		/**************************
    		 *   Millésime
    		 **************************/
    		foreach($types as $type)
    		{
    			$output->writeln(">> traitement du modéle : " . $type['name']);
    			sleep(1);
				//Recuperation du type
    			preg_match_all("|/(.*)---(.*).html|",$type['url'],$tab_type,PREG_PATTERN_ORDER );
    			$type_car=$tab_type[2][0];
    			
    			$handle = file_get_contents("http://www.lacentrale.fr/" . $type['url']);
    			$start = strpos($handle,'<div style="clear:left;" class="CoteListMillesime">');
    			$end = strpos($handle,'<!-- / tz_ftco_auto.php -->');
    			$text = substr ( $handle , $start, $end - $start);
    			preg_match_all("|<a href=\"(.*)\">(.*) - (.*)</a>|",$text,$finds,PREG_PATTERN_ORDER );
	    		$years = array();
	    		for ($i=0;$i<count($finds[0]); $i++)
	    		{
	    			$years[]=array('url'=>$finds[1][$i],"name"=>$finds[3][$i]);
	    		}
	    		$output->writeln(">>" . count($years) . ' années trouvés');
	    		/**************************
	    		 *   Version
	    		 **************************/
    			foreach($years as $year)
    			{ 
    				$output->writeln(">>> traitement de l'année : " . $year['name']);
    				sleep(1);
    				$handle = file_get_contents("http://www.lacentrale.fr/" . $year['url']);
    				$versions=array();
    				if(!preg_match('|<h2 id="titreCote">Cote brute </h2>|', $handle))
    				{
    					$start = strpos($handle,'<!-- end file tz_top_listing_ftco_ve_flat.php -->');
    					$end = strpos($handle,'<div id="TabAnnHomeFootDivCote" >');
    					$handle = substr ( $handle , $start, $end - $start);
    					$html_tab = array();
    					//On compte le nombre de TR du tableau
    					preg_match_all('|<tr onmouseover="this.style.backgroundColor=\'#CDDCF3\';" onmouseout="this.style.backgroundColor=\'#ffffff\';">|',$handle,$tab,PREG_PATTERN_ORDER);
    					
    					//Decoupage du premier TR
    					$start = strpos($handle,'<tr onmouseover="this.style.backgroundColor=\'#CDDCF3\';" onmouseout="this.style.backgroundColor=\'#ffffff\';">');
    					$end = strpos($handle,"<!-- end file tb_item_listing_auto_quot_flat.php -->");
    					$end_length = strlen("<!-- end file tb_item_listing_auto_quot_flat.php -->");
    					$text_sh = substr ( $handle , $start, $end - $start);
    					$html_tab[]=$text_sh;
    					
    					//Decoupage des autres TR
    					$i = 2;
    					while($i <= count($tab[0]))
    					{
    						//On supprime le texte déja traité
    						$handle = substr ( $handle , $end + $end_length);
    						$start = strpos($handle,'<!-- begin file tb_item_listing_auto_quot_flat.php -->');
    						$end = strpos($handle,"<!-- end file tb_item_listing_auto_quot_flat.php -->");
    						$text = substr ( $handle , $start, $end - $start);
    						$html_tab[]=$text;
    						$i++;
    					}
    					
    					foreach($html_tab as $tab)
    					{
    							
    						preg_match_all('|<a .*>(.*)</a>|',$tab,$test,PREG_PATTERN_ORDER);
    						preg_match_all('| href="(.*)" |',$test[0][0],$test2,PREG_PATTERN_ORDER);
    					
    						$tmp =array();
    						$tmp["url"]=$test2[1][0];
    						$tmp["name"]=$test[1][0];
    						$tmp["energie"]=$test[1][2];
    						$tmp["PuissanceF"]=$test[1][3];
    						$tmp["boite"]=$test[1][4];
    						$tmp["porte"]=$test[1][5];
    						$tmp["type"]=$type_car;
    						$tmp["year"]=$year["name"];
    						$tmp["marque"]=$marque;
    						$versions[]=$tmp;
    					}
    				}else{
    					
    					preg_match_all('|<h1>(.*) - '. $year['name'] .' - (.*)</h1>|',$handle,$name_tab,PREG_PATTERN_ORDER);
    					$tmp =array();
    					$tmp["url"]=$year['url'];
    					$tmp["name"]=$name_tab[2][0];
    					$tmp["energie"]=false;
    					$tmp["PuissanceF"]=false;
    					$tmp["boite"]=false;
    					$tmp["porte"]=false;
    					$tmp["type"]=$type_car;
    					$tmp["year"]=$year["name"];
    					$tmp["marque"]=$marque;
    					$versions[]=$tmp;
    				}
    				$output->writeln(">>>" . count($versions) . ' versions trouvées');
    				foreach($versions as $k=>$version)
    				{
    					sleep(1);
    					$output->writeln(">>>> traitement de la version : " . $version['name']);
    					$handle = file_get_contents("http://www.lacentrale.fr/" . $version['url']);
    					preg_match_all('|<span class="Result_Cote arial tx20">(.*) (.*)</span>|',$handle,$tab_price,PREG_PATTERN_ORDER);
    					$price =str_replace(' ','',$tab_price[1][0]);
    					$versions[$k]["price"]=intval($price);
    					var_dump($versions[$k]);
    					sleep(1);
    				}

    			}
    			die();
    		}
    		die();
    	}
    	
    }
}