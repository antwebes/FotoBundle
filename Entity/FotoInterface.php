<?php

namespace ant\FotoBundle\Entity;


interface FotoInterface {
	
	/**
	 * Set imageName
	 *
	 * @param string $imageName
	 * @return FotoPerfil
	 */
	public function setImageName($imageName);

	/**
	 * Get imageName
	 *
	 * @return string 
	 */
	public function getImageName();

	public function getTitulo();
	
	public function setTitulo($titulo);
	
	
	public function getImage();

	public function setImage($image);
	public function getImagenPerfil();
	
	public function setImagenPerfil($imagenPerfil);
    /**
     * Set fecha_publicacion
     *
     * @param \DateTime $fechaPublicacion
     * @return Foto
     */
    public function setFechaPublicacion($fechaPublicacion);

    /**
     * Get fecha_publicacion
     *
     * @return \DateTime 
     */
    public function getFechaPublicacion();

    

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Foto
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt();

    /**
     * Set imagePerfilName
     *
     * @param string $imagePerfilName
     * @return Foto
     */
    public function setImagePerfilName($imagePerfilName);

    /**
     * Get imagePerfilName
     *
     * @return string 
     */
    public function getImagePerfilName();

    
}