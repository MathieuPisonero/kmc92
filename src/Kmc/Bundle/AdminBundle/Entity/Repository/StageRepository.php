<?php

// src/AppBundle/Entity/ProductRepository.php
namespace Kmc\Bundle\AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Kmc\Bundle\AdminBundle\Entity\StageSubscription;
class StageRepository extends EntityRepository
{
	public function GenKey($string)
	{
		$key = mb_strtolower($string, 'UTF-8');
		$key = str_replace(
				array(
						'à', 'â', 'ä', 'á', 'ã', 'å',
						'î', 'ï', 'ì', 'í',
						'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
						'ù', 'û', 'ü', 'ú',
						'é', 'è', 'ê', 'ë',
						'ç', 'ÿ', 'ñ',
						'\'','"',' '
				),
				array(
						'a', 'a', 'a', 'a', 'a', 'a',
						'i', 'i', 'i', 'i',
						'o', 'o', 'o', 'o', 'o', 'o',
						'u', 'u', 'u', 'u',
						'e', 'e', 'e', 'e',
						'c', 'y', 'n',
						'','','',''
				),
				$key
		);
		$stage = $this->findOneBy(array('urlKey' => $key));
		if(empty($stage))
		{
			return urlencode($key);
		}else
		{
			$find = false;
			$i=1;
			while(!$find)
			{
				$stage = $this->findOneBy(array('urlKey' => $key.$i));
				if(empty($stage))
					return urlencode($key.$i);
				else
					$i ++;
			}
		}
	}
	
	public function countSubscription($id)
	{
		$qb = $this->createQueryBuilder('si')
				   ->select('COUNT (a) as nb')
				   ->Join('KmcAdminBundle:StageSubscription','a')
				   ->groupBy('a.id')
				   ->where("si.id=a.stage  AND si.id=" . 2)
				   ->OrderBy("nb", 'desc');
		$query = $qb->getQuery();
	}
}