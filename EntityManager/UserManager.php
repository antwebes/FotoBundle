<?php

namespace ant\FotoBundle\EntityManager;

use Doctrine\ORM\EntityManager;

/**
* Abstract Usuario Manager implementation which can be used as base by
* your concrete manager.
*
* @author Pablo Cancelo <pablo@antweb.es>
*/

class UserManager
{
	/**
	 * @var EntityManager
	 */
	protected $em;
	
	/**
	 * @var DocumentRepository
	 */
	protected $repository;
	
	/**
	 * @var string
	 */
	protected $class;
	private $ladybug;
	private $securityContext;
	
	
	/**
	 * Constructor.
	 *
	 * @param EntityManager $em
	 * @param string $class
	 * @param string $metaClass
	 */
	public function __construct(EntityManager $em, $class, $ladybug, $securityContext)
	{
		$this->em = $em;
		$this->repository = $em->getRepository($class);
		$this->ladybug = $ladybug;
		$this->class = $em->getClassMetadata($class)->name;
		//ldd($this->class);
		$this->securityContext = $securityContext;
		
		//$this->metaClass = $em->getClassMetadata($metaClass)->name;
	}
	/**
	 * {@inheritDoc}
	 */
	public function findUserBy(array $criteria)
	{
		return $this->repository->findOneBy($criteria);
	}
	
	public function findOneByUsername($username)
	{		
		$query = $this->repository
				->createQueryBuilder('n')
				->where('n.own = :usuarioId')		
				->orderBy('n.fecha_publicacion', 'DESC')
				->setParameter('usuarioId', $u->getId());
		$notificaciones = $query
				->getQuery()
				->execute();
		return $notificaciones;
	}
	
	
	/**
	 * Returns the fully qualified comment thread class name
	 *
	 * @return string
	 */
	public function getClass()
	{
		return $this->class;
	}
	
	
}