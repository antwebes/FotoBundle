<?php

namespace ant\FotoBundle\Entity;


interface ComponentInterface {
	
	/**
	 * {@inheritdoc}
	 */
	public function setData($data);
	
	/**
	 * {@inheritdoc}
	 */
	public function getData();
	/**
	 * {@inheritdoc}
	 */
	public function buildHash();
	/**
	 * {@inheritdoc}
	 */
	public function getHash();
	
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
	public function setModel($model);
	
	/**
	 * {@inheritdoc}
	 */
	public function getModel();
	
	/**
	 * {@inheritdoc}
	 */
	public function setIdentifier($identifier);
	
	/**
	 * {@inheritdoc}
	 */
	public function getIdentifier();
	
}