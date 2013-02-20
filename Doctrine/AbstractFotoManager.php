<?php

namespace ant\FotoBundle\Doctrine;


use ant\FotoBundle\Entity\ComponentInterface;

use ant\FotoBundle\Entity\FotoInterface;
use Doctrine\ORM\Query\Expr;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * AbstractFotoManager
 *
 * @author Pablo  <pablo@antweb.es>
 */
class AbstractFotoManager
{
	/**
	 * @var ObjectManager
	 */
	protected $objectManager;
		
	/**
	 * @var string
	 */
	protected $fotoClass;
	
	/**
	 * @var string
	 */
	protected $componentClass;
	
	/**
	 * @var string
	 */
	protected $fotoComponentClass;
	
	/**
	 * @param ObjectManager          $objectManager        objectManager
	 * @param string                 $fotoClass            fotoClass
	 * @param string                 $componentClass       componentClass
	 * @param string                 $fotoComponentClass   fotoComponentClass
	 */
	public function __construct(ObjectManager $objectManager, $fotoClass, $componentClass, $fotoComponentClass)
	{
		$this->objectManager        = $objectManager;
		$this->fotoClass            = $fotoClass;
		$this->componentClass       = $componentClass;
		$this->fotoComponentClass   = $fotoComponentClass;
	}
	
	/**
	 * {@inheritdoc}
	 * CREAMOS LA ENTIDAD COMPONENT
	 */
	public function createComponent($model, $identifier = null, $flush = true)
	{
		list ($model, $identifier, $data) = $this->resolveModelAndIdentifier($model, $identifier);
	
		if (empty($model) || null === $identifier || '' === $identifier) {
			if (is_array($identifier)) {
				$identifier = implode(', ', $identifier);
			}
	
			throw new \Exception(sprintf('To create a component, you have to give a model (%s) and an identifier (%s)', $model, $identifier));
		}
	
		$component = new $this->componentClass();
		$component->setModel($model);
		$component->setData($data);
		$component->setIdentifier($identifier);
	
		$this->objectManager->persist($component);
	
		if ($flush) {
			$this->flushComponents();
		}
	
		return $component;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function flushComponents()
	{
		$this->objectManager->flush();
	}
	
	/**
	 * resolveModelAndIdentifier
	 *
	 * @param mixed $model      model
	 * @param mixed $identifier identifier
	 *
	 * @return array(string, array|string)
	 */
	protected function resolveModelAndIdentifier($model, $identifier)
	{
		if (!is_object($model) && (null === $identifier || '' === $identifier)) {
			throw new \LogicException('Model has to be an object or a scalar + an identifier in 2nd argument');
		}
	
		$data = null;
	
		if (is_object($model)) {
			$data       = $model;
			$modelClass = get_class($model);
			$metadata   = $this->objectManager->getClassMetadata($modelClass);
	
			// if object is linked to doctrine
			if (null !== $metadata) {
				$fields     = $metadata->getIdentifier();
				if (!is_array($fields)) {
					$fields = array($fields);
				}
				$many       = count($fields) > 1;
	
				$identifier = array();
				foreach ($fields as $field) {
					$getMethod = sprintf('get%s', ucfirst($field));
					$value     = (string) $model->{$getMethod}();
	
					//Do not use it: https://github.com/stephpy/TimelineBundle/issues/59
					//$value = (string) $metadata->reflFields[$field]->getValue($model);
	
					if (empty($value)) {
						throw new \Exception(sprintf('Field "%s" of model "%s" return an empty result, model has to be persisted.', $field, $modelClass));
					}
	
					$identifier[$field] = $value;
				}
	
				if (!$many) {
					$identifier = current($identifier);
				}
	
				$model = $metadata->name;
			} else {
				if (!method_exists($model, 'getId')) {
					throw new \LogicException('Model must have a getId method.');
				}
	
				$identifier = $model->getId();
				$model      = $modelClass;
			}
		}
	
		if (is_scalar($identifier)) {
			$identifier = (string) $identifier;
		} elseif (!is_array($identifier)) {
			throw new \InvalidArgumentException('Identifier has to be a scalar or an array');
		}
	
		return array($model, $identifier, $data);
	}
	
	/**
	 * @param FotoInterface $foto    foto
	 * @param string          $type      type
	 * @param mixed           $component component
	 */
	public function addComponent($foto, $type, $component)
	{
	
		if (!$component instanceof ComponentInterface && !is_scalar($component)) {
			
			$component = $this->findOrCreateComponent($component);
	
			if (null === $component) {
				throw new \Exception(sprintf('Impossible to create component from %s.', $type));
			}
		}
		
		$foto->addComponent($type, $component, $this->fotoComponentClass);
	}
	/**
	 * {@inheritdoc}
	 */
	public function findOrCreateComponent($model, $identifier = null, $flush = true)
	{
		
		list ($modelResolved, $identifierResolved, $data) = $this->resolveModelAndIdentifier($model, $identifier);
	
		if (empty($modelResolved) || null === $identifierResolved || '' === $identifierResolved) {
			if (is_array($identifierResolved)) {
				$identifierResolved = implode(', ', $identifierResolved);
			}
	
			throw new \Exception(sprintf('To find a component, you have to give a model (%s) and an identifier (%s)', $modelResolved, $identifierResolved));
		}
	
		$component = $this->getComponentRepository()
			->createQueryBuilder('c')
			->where('c.model = :model')
			->andWhere('c.identifier = :identifier')
			->setParameter('model', $modelResolved)
			->setParameter('identifier', serialize($identifierResolved))
			->getQuery()
			->getOneOrNullResult()
			;

		if ($component) {
			$component->setData($data);
	
			return $component;
		}
	
		return $this->createComponent($model, $identifier, $flush);
	}
	/**
	 * {@inheritdoc}
	 */
	public function create($subject, $verb, array $components = array())
	{
		//$foto = new $this->fotoClass();
		//$foto->setVerb($verb);
		$foto=$subject;
		if (!$subject instanceof ComponentInterface AND !is_object($subject)) {
			throw new \Exception('Subject must be a ComponentInterface or an object');
		}
	
		//$components['subject'] = $subject;
		foreach ($components as $type => $component) {
			$this->addComponent($foto, $type, $component);
		}
	
		return $foto;
	}
	/**
	 * {@inheritdoc}
	 */
	public function updateAction(FotoInterface $foto)
	{
		$this->objectManager->persist($foto);
		$this->objectManager->flush();
	}
	/**
	 * {@inheritdoc}
	 */
	public function getQueryBuilderForComponent(ComponentInterface $component){
	
		return $this->objectManager
			->getRepository($this->fotoClass)
			->createQueryBuilder('a')
			->innerJoin('a.fotoComponents', 'ac2', Expr\Join::WITH, '(ac2.foto = a AND ac2.component = :component)')
			->leftJoin('a.fotoComponents', 'ac')
			->setParameter('component', $component)
			->getQuery()->getResult()
		;
	}
	
	/*
	 * envio un objecto, lo busco como componente y devuelvo sus fotos
	 */
	public function labeled($object)
	{
	//	$repository = $this->objectManager->getRepository($class);		
	//	$usuario = $repository->findOneById(2);		
		$component       = $this->findOrCreateComponent($object);
		return $this->getQueryBuilderForComponent($component);

	}
	
	protected function getComponentRepository()
	{
		return $this->objectManager->getRepository($this->componentClass);
	}
	
	public function getUser($id)
	{
		return $this->get('ant_foto.userService')->findUserById($id);
	}
	
}