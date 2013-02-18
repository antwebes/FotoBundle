<?php

namespace ant\FotoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;


abstract class Foto implements FotoInterface {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=255)	 
	 */
	protected $verb;

	/**
	 * @ORM\Column(type="string", length=255, name="image_name", nullable=true)	 
	 */
	protected $imageName;
	/**
	 * @ORM\Column(type="string", length=255, name="image_perfil_name", nullable=true)
	 */
	protected $imagePerfilName;
	/**
	 * @Assert\File(
	 *     maxSize="2000k",
	 *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
	 * )
	 * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
	 *
	 * @var File $image
	 */
	public $image;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 *
	 * @Assert\DateTime
	 */
	protected $updatedAt;
	/**
	 * @var array
	 */
	protected $fotoComponents;
	/**
	 * @Assert\File(
	 *     maxSize="2000k",
	 *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
	 * )
	 * @Vich\UploadableField(mapping="imagen_perfil", fileNameProperty="imagePerfilName")
	 *
	 * @var File $imagenPerfil
	 */
	public $imagenPerfil;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 *
	 * @Assert\Date
	 */
	protected $fecha_publicacion;

	/**
	 * @ORM\Column(type="string", length=255, name="titulo", nullable=true)
	 */
	protected $titulo;
	
	public function __toString(){
		return $this->imageName;
	}
	public function __construct()
	{
		$this->fecha_publicacion = new \DateTime('now');
	}
	/**
	 * {@inheritdoc}
	 */
	public function setVerb($verb)
	{
		$this->verb = $verb;
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getVerb()
	{
		return $this->verb;
	}
	/**
	 * {@inheritdoc}
	 */
	public function addComponent($type, $component, $fotoComponentClass)
	{
		$fotoComponent = new $fotoComponentClass();
		$fotoComponent->setType($type);
	
		if ($component instanceof ComponentInterface) {
			$fotoComponent->setComponent($component);
		} elseif (is_scalar($component)) {
			$fotoComponent->setText($component);
		} else {
			throw new \InvalidArgumentException('Component has to be a ComponentInterface or a scalar');
		}
	
		$this->addFotoComponent($fotoComponent);
	
		return $this;
	}
	/**
	 * {@inheritdoc}
	 */
	public function addFotoComponent(FotoComponentInterface $fotoComponent)
	{
		$fotoComponent->setFoto($this);
		$type = $fotoComponent->getType();
	
		foreach ($this->getFotoComponents() as $key => $ac) {
			if ($ac->getType() == $type) {
				unset($this->fotoComponents[$key]);
			}
		}
	
		$this->fotoComponents[] = $fotoComponent;
	
		return $this;
	}
	/**
	 * @return array
	 */
	public function getFotoComponents()
	{
		return $this->fotoComponents;
	}
	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set imageName
	 *
	 * @param string $imageName
	 * @return FotoPerfil
	 */
	public function setImageName($imageName) {
		$this->imageName = $imageName;

		return $this;
	}

	/**
	 * Get imageName
	 *
	 * @return string 
	 */
	public function getImageName() {
		return $this->imageName;
	}
	public function setId($id) {
		$this->id = $id;
	}

	public function getTitulo() {
		return $this->titulo;
	}
	
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}
	
	
	public function getImage() {
		return $this->image;
	}

	public function setImage($image) {
		$this->image = $image;
	}
	public function getImagenPerfil() {
		return $this->imagenPerfil;
	}
	
	public function setImagenPerfil($imagenPerfil) {
		$this->imagenPerfil = $imagenPerfil;
	}

    /**
     * Set fecha_publicacion
     *
     * @param \DateTime $fechaPublicacion
     * @return Foto
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fecha_publicacion = $fechaPublicacion;
    
        return $this;
    }

    /**
     * Get fecha_publicacion
     *
     * @return \DateTime 
     */
    public function getFechaPublicacion()
    {
        return $this->fecha_publicacion;
    }

    /**
     * Set usuario
     *
     * @param chatea\UsuarioBundle\Entity\User $usuario
     * @return Foto
     */
    public function setUsuario(\chatea\UsuarioBundle\Entity\User $usuario = null)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return chatea\UsuarioBundle\Entity\User 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Foto
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set imagePerfilName
     *
     * @param string $imagePerfilName
     * @return Foto
     */
    public function setImagePerfilName($imagePerfilName)
    {
        $this->imagePerfilName = $imagePerfilName;
    
        return $this;
    }

    /**
     * Get imagePerfilName
     *
     * @return string 
     */
    public function getImagePerfilName()
    {
        return $this->imagePerfilName;
    }

    
}