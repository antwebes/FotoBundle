<?php

namespace ant\FotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ant_foto_foto_component")
 */
class FotoComponent implements FotoComponentInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="chatea\FotoBundle\Entity\Foto", inversedBy="fotoComponents")
     * @ORM\JoinColumn(name="foto_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $foto;

    /**
     * @ORM\ManyToOne(targetEntity="ant\FotoBundle\Entity\Component")
     * @ORM\JoinColumn(name="component_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $component;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $type;
    
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
    public function setType($type)
    {
    	$this->type = $type;
    
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
    	return $this->type;
    }
    /**
     * {@inheritdoc}
     */
    public function setFoto(FotoInterface $foto)
    {
    	$this->foto = $foto;
    
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFoto()
    {
    	return $this->foto;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setComponent(ComponentInterface $component)
    {
    	$this->component = $component;
    
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getComponent()
    {
    	return $this->component;
    }
}