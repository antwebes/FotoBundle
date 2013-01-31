<?php

/*
 * This file is part of the AntFotoBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ant\FotoBundle\Doctrine;

use Doctrine\ORM\EntityManager;
//use FOS\UserBundle\Model\UserInterface;
//use FOS\UserBundle\Model\UserManager as BaseUserManager;
//use FOS\UserBundle\Util\CanonicalizerInterface;

class FotoManager //extends BaseUserManager
{
	/**
	 * @var EntityManager
	 */
	protected $em;
    protected $class;
    protected $repository;
    /**
     * Constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param CanonicalizerInterface  $usernameCanonicalizer
     * @param CanonicalizerInterface  $emailCanonicalizer
     * @param ObjectManager           $om
     * @param string                  $class
     */
    public function __construct(EntityManager $em, $class)
    {
        //parent::__construct($encoderFactory);
        $this->em = $em;
        
        $this->repository = $em->getRepository($class);
        $this->class = $em->getClassMetadata($class)->name;
        
       /* $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();*/
    }

    /**
     * {@inheritDoc}
     */
    public function deleteUser(UserInterface $user)
    {
        $this->objectManager->remove($user);
        $this->objectManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function findUserBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findUsers()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function reloadUser(UserInterface $user)
    {
        $this->objectManager->refresh($user);
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     */
    public function updateUser(UserInterface $user, $andFlush = true)
    {
        $this->updateCanonicalFields($user);
        $this->updatePassword($user);

        $this->objectManager->persist($user);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
    /**
     * Returns an empty user instance
     *
     * @return UserInterface
     */
    public function createFoto()
    {
    	$class = $this->getClass();
    	$foto = new $class;
    
    	return $foto;
    }
}
