<?php

namespace ant\FotoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;


class Component {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $model;
	
	/**
	 * @var array
	 */
	protected $identifier;
	
	/**
	 * {@inheritdoc}
	 */
	public function setId($id)
	{
		$this->id = $id;
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setModel($model)
	{
		$this->model = $model;
	
		if (null !== $this->getIdentifier()) {
			$this->buildHash();
		}
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getModel()
	{
		return $this->model;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setIdentifier($identifier)
	{
		if (is_scalar($identifier)) {
			// to avoid issue of serialization.
			$identifier = (string) $identifier;
		} elseif (!is_array($identifier)) {
			throw new \InvalidArgumentException('Identifier must be a scalar or an array');
		}
	
		$this->identifier = $identifier;
	
		if (null !== $this->getModel()) {
			$this->buildHash();
		}
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}

    
}