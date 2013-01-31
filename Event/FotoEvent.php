<?php

namespace ant\FotoBundle\Event;

use ant\FotoBundle\Entity\FotoInterface;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\Event;
use Doctrine\ORM\EntityManager;

class FotoEvent extends Event
{
	/**
	 * The foto
	 * @var FotoInterface
	 */
	private $foto;
	
	public function __construct(FotoInterface $foto)
	{	
		$this->foto = $foto;
	}
	
	/**
	 * Returns the foto
	 *
	 * @return FotoInterface
	 */
	public function getFoto()
	{
		return $this->foto;
	}
}
