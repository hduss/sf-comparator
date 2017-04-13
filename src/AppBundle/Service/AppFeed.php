<? php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;


class AppFeed
{
	private $manager;

	public function __construct(EntityManager $manager)
	{
		$this->manager = $manager;
	}


}