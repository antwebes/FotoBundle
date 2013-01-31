<?php

namespace ant\FotoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FotoType extends AbstractType{

	private $fotoClass;
	
	public function __construct($fotoClass)
	{
		$this->fotoClass = $fotoClass;
	}
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

	/*public function getDefaultOptions(array $options)
	{
		return array(
		'data_class' => 'ant\FotoBundle\Entity\Foto'
		);
	}*/
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'intention'  => 'foto',
				'data_class' => $this->fotoClass,
		));
	}
	public function getName()
	{
		return 'ant_foto_type';
	}
}