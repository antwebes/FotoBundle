<?php

namespace chatea\FotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class FotoPerfilType extends AbstractType{

public function buildForm(FormBuilderInterface $builder, array $options)
{
	$builder->add('imageName')
		->add('fecha_publicacion', 'date')
		->add('imagenPerfil', 'file', array(
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
		return 'FotoPerfilType';
	}
}