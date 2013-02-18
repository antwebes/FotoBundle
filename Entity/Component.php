<?php

namespace ant\FotoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="ant_foto_component")
 */
class Component implements ComponentInterface {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="model", type="string", length=255)
	 * @var string
	 */
	protected $model;
	
	/**
	 * @ORM\Column(type="array")
	 */
	protected $identifier;
	/**
	 * @ORM\Column(name="hash", type="string", unique=true)
	 */
	protected $hash;
	
	/**
	 * Data defined on this component.
	 *
	 * @var mixed
	 */
	protected $data;
	/**
	 * {@inheritdoc}
	 */
	public function setData($data)
	{
		$this->data = $data;
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getData()
	{
		return $this->data;
	}
	/**
	 * {@inheritdoc}
	 */
	public function buildHash()
	{
		$this->hash = $this->getModel().'#'.serialize($this->getIdentifier());
	}
	/**
	 * {@inheritdoc}
	 */
	public function getHash()
	{
		return $this->hash;
	}
	
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