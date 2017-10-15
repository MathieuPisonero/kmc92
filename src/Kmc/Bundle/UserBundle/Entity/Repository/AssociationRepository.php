<?php

namespace Kmc\Bundle\UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Kmc\Bundle\UserBundle\Entity\User;
use Kmc\Bundle\UserBundle\Entity\Association;

class AssociationRepository extends EntityRepository
{
	
	public function findUserList(User $user, Association $association = null)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a')
		->groupBy('a.id')
		->where("a.user=".$user->getId())
		->OrderBy("a.name", 'asc');
		if(empty ($association)){
			$qb->andWhere("a.parentclub is NULL");
		}else{
			$qb->andWhere("a.parentclub = ". $association->getId());
		}
		$query = $qb->getQuery();
		return $query->getResult();
	}
}