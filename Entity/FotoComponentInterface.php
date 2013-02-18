<?php

namespace ant\FotoBundle\Entity;


interface FotoComponentInterface {
	/**
	 * {@inheritdoc}
	 */
	public function setId($id);
	
	/**
	 * {@inheritdoc}
	 */
	public function getId();
	/**
	 * {@inheritdoc}
	 */
	public function setType($type);
	
	/**
	 * {@inheritdoc}
	 */
	public function getType();
	/**
	 * {@inheritdoc}
	 */
	public function setFoto(FotoInterface $foto);
	
	/**
	 * {@inheritdoc}
	 */
	public function getFoto();
	
	/**
	 * {@inheritdoc}
	 */
	public function setComponent(Component $component);
	
	/**
	 * {@inheritdoc}
	 */
	public function getComponent();
}