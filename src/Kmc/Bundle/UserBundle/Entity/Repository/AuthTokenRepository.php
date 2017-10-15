<?php

namespace Kmc\Bundle\UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Kmc\Bundle\UserBundle\Entity\User;

class AuthTokenRepository extends EntityRepository
{
	public function removeTokens (User $user)
	{
		$qb = $this->createQueryBuilder('si')->delete()->where("si.user=" . $user->getId() );

		$query = $qb->getQuery();
		return $query->getResult();
	}
}