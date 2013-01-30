<?php

namespace chatea\FotoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FotoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FotoRepository extends EntityRepository
{
	public function findFotosUsuario($usuario){		
		$em = $this->getEntityManager();
		$Query = $em->createQuery('SELECT foto FROM chatea\FotoBundle\Entity\Foto foto
				WHERE foto.usuario = :usuario AND foto.imageName is NOT NULL ORDER BY foto.fecha_publicacion');
		$Query->setParameter('usuario', $usuario);
		//$this->get('ladybug')->log($usuario);
		return $Query->getResult();
	}
}
