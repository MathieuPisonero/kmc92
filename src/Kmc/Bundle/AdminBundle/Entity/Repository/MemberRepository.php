<?php

// src/AppBundle/Entity/ProductRepository.php
namespace Kmc\Bundle\AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository
{
	public function findAllFilter($filter)
	{
		/*$qb = $this->createQueryBuilder('m, ms');
		$qb->join('m.KmcAdminBundle:MemberSeason', 'ms');
		$qb->join('ms.KmcKmcBundle:Season', 's');
		$qb->where('m.id=ms.member AND s.id = 1');
		return($qb->getQuery()->getResult());*/
		
		$qb = $this->createQueryBuilder('m')
		->Join('m.seasons',  'ms')
		->Join('ms.season', 's');
		$where = array();
		if(!empty($filter["season"]) && $filter["season"] != 'all')
			$where[] = "s.id=". $filter["season"];
		if(!empty($filter["season"]) && $filter["level"] != 'all')
			$where[] = "m.praticelevel='". $filter["level"] . "'";
		if(!empty($filter["season"]) && $filter["minor"])
			$where[] = "m.major=0";
		if(count($where))
			$qb->where(implode(" and ", $where));
		$query = $qb->getQuery();
		return $query->getResult();	
	}
}