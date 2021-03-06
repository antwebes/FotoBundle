<?php

namespace ant\FotoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FotoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FotoComponentRepository extends EntityRepository
{
	/**
	 * 
	 * @param integer $foto_id
	 */
	public function findComponent($foto_id){
		$em = $this->getEntityManager();
		$Query = $em->createQuery('SELECT fc FROM ant\FotoBundle\Entity\FotoComponent fc
				WHERE fc.foto = :foto_id');
		$Query->setParameter('foto_id', $foto_id);
		//$this->get('ladybug')->log($usuario);
		return $Query->getResult();
	}
}