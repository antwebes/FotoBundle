<?php

namespace chatea\FotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class FotoType extends AbstractType{

public function buildForm(FormBuilderInterface $builder, array $options)
{
	$builder->add('titulo')
		->add('image', 'file', array(
                    'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                    'property_path' => 'image',
                    'required' => true,
                ))
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
		'data_class' => 'chatea\FotoBundle\Entity\Foto'
		);
	}
	
	public function getName()
	{
		return 'Foto';
	}
}