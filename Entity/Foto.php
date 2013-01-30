<?php

namespace chatea\FotoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="Foto")
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="chatea\FotoBundle\Entity\FotoRepository")
 */
class Foto {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

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
	 * @ORM\ManyToOne(targetEntity="chatea\UsuarioBundle\Entity\User", inversedBy="fotos")
	 * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
	 */
	//usuario_id nombre en la base de datos que relaciona con la columna id del usuario
	protected $usuario;
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