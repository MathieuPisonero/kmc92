<?php 
// src/AppBundle/Command/GreetCommand.php

namespace Kmc\Bundle\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class GenCardCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('admin:gencard')
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
    	$season=2;
    	$first = $input->getArgument('start');
    	$max = $input->getArgument('start')+500;
    	$repository = $this->getContainer()->get('doctrine')->getRepository('KmcKmcBundle:Subscription');
    	$query = $repository->createQueryBuilder('p')
					    	->setFirstResult($first)
					    	->setMaxResults($max)
					    	->getQuery();
    	$subs = $query->getResult();
    	
    	$html = '<div style="margin-bottom:5px">';
    	$i = $first +1;
        foreach($subs as $sub)
        {
        	
        	$url = $this->img($sub);
        	$html .= '<img src="'.$url.'" style="margin-right:5px"/>';
        	if(($i % 2) == 0)
        	{
        		$html .= '</div><div style="margin-bottom:5px">';
        	}
        	$i++;
        	$output->writeln($i);
        }
        $data = $this->getContainer()->get('knp_snappy.pdf')->getOutputFromHtml($html);
        
        $fs = new Filesystem();
        $filename_licence = 'card_licence'.$first.'.pdf';
        $fs->dumpFile('/home/kmc/www/web/card/' . $filename_licence, $data);
    }
    
    public function civ($civ)
    {
    	switch($civ)
    	{
    		case 0: return 'Melle';break;
    		case 1: return 'Me';break;
    		case 2: return 'M';break;
    	}
    }
    public function img($sub)
    {
    	$new_name = '/home/kmc/www/web/card/member_card/carte_'.$sub->getId().'.jpg';
    	$im = @imagecreatefromjpeg("/home/kmc/www/web/card/carte.jpg");
    	$font_file = '/home/kmc/www/web/card/arial.ttf';
    	$black = imagecolorallocate($im, 0x00, 0x00, 0x00);
    	$text = $sub->getLastName() . " ". $sub->getFirstName();
    	imagefttext($im, 30, 0, 300, 530, $black, $font_file, strtoupper ($text));
    	
    	list($width, $height) = getimagesize("/home/kmc/www/web/card/carte.jpg");
    	$percent = 0.3;
    	$new_width = $width * $percent;
    	$new_height = $height * $percent;
    	$image_p = imagecreatetruecolor($new_width, $new_height);
    	imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    	imagejpeg($image_p,$new_name ,100);
    	return ($new_name);
    }
}