<?php

namespace Kmc\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KmcUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
