<?php

// src/AppBundle/Entity/ProductRepository.php
namespace Kmc\Bundle\KmcBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class InformationSubscriptionRepository extends EntityRepository
{
	public function getResult($seson,$question)
	{
		$qb = $this->createQueryBuilder('si')
		->select('a.id, a.text,COUNT (a) as nb, a.custom')
		->Join('si.subscription',  'sb')
		->Join('sb.season',  's')
		->Join('si.question', 'q')
		->Join('si.answer', 'a')
		->groupBy('a.id')
		->where("s.id=".$seson." AND q.id=".$question)
		->OrderBy("nb", 'desc');
		$query = $qb->getQuery();
		return $query->getResult();
	}
	
	public function getCustomResult($seson, $question, $answer)
	{
		$qb = $this->createQueryBuilder('si')
		->select('si.custom, COUNT (si) as nb')
		->Join('si.subscription',  'sb')
		->Join('sb.season',  's')
		->Join('si.question', 'q')
		->Join('si.answer', 'a')
		->groupBy('si.custom')
		->where("a.custom=1 AND s.id=".$seson." AND q.id=".$question." AND a.id=".$answer)
		->OrderBy("nb", 'desc');
		$query = $qb->getQuery();
		return $query->getResult();
	}
}