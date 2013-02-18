<?php

namespace ant\FotoBundle\Controller;

use ant\FotoBundle\Event\AntFotoEvents;
use ant\FotoBundle\Event\FotoEvent;
use ant\FotoBundle\Form\FotoType;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ant\FotoBundle\Entity\Foto; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use ant\SocialBundle\Model\NotificacionInterface;


class FotoController extends Controller
{
	/**
	 * @Rest\View
	 */
    public function indexAction($id)
    {    	
    	$fotoManager = $this->get('ant_foto.foto_manager');
    	$foto = $fotoManager->findFotoBy(array('id'=>$id));
    	//fotoComponent
    	$usuario = $this->get('security.context')->getToken()->getUser();
    	$fotoManager = $this->get('ant_foto.action_manager.orm');
    	$subject       = $fotoManager->findOrCreateComponent($usuario);
    	$foto = $fotoManager->create($subject, 'foto', array('directComplement' => $foto));
    	$fotoManager->updateAction($foto);
    	ldd($usuario);
    	//fin FotoComponent
        return array('foto' => $foto);
    }
    /**
     * @Rest\View
     */
    public function fotoPathAction($path)
    {
    	return array('path' => $path);
    }
    
    
    
    public function editarAction(Foto $foto) {
    		$request = $this->getRequest();

    		$em = $this->getDoctrine()->getManager();
    		$foto->setTitulo(htmlspecialchars($request->get("titulo")));
    		$em->persist($foto);
    		$em->flush();
  
    	
    	return array("foto" => $foto);
    }
    
    /**
     * DEPRECATED
    
    public function imagenesUsuarioAction($u)
    {
    	//$u = $this->get('security.context')->getToken()->getUser();
    	//$u = $em->getRepository('UsuarioBundle:User')->findOneById($id);
    	$em = $this->getDoctrine()->getManager();
    	$fotos = $em->getRepository('FotoBundle:Foto')->findFotosUsuario($u);
    	$this->get('ladybug')->log($fotos);
    	
    	return $this->render('FotoBundle:Compartido:listaFotos.html.twig', 
    			array('fotos' => $fotos,
    					'path' => 'fotos/'));
    }
    */
    
    /**
     * @Rest\View
     */
    public function uploadAction()
    {
    	$formFactory = $this->get('ant_foto.form.factory');
    	$fotoManager = $this->get('ant_foto.foto_manager');
    	$foto = $fotoManager->createFoto();
    	$form = $formFactory->createForm();
    	$form->setData($foto);
    	//$form = $this->get('form.factory')->create(new FotoType());
    	
    	if ($this->getRequest()->isMethod('POST')) {
    		$form->bind($this->getRequest());
    		if ($form->isValid()) {
    			//$foto = $form->getData();
    			
    			$em = $this->getDoctrine()->getManager();    			
    			$u = $this->get('security.context')->getToken()->getUser();
    			$this->get('ant_social.NotificacionManager')->crearNotificacion($u, NotificacionInterface::FOTO, $foto);
    			$foto->setUsuario($u);
    			$em->persist($foto);
        		$em->flush();
        		//lanzamos un evento
        		$dispatcher = $this->container->get('event_dispatcher');        		
        		$dispatcher->dispatch(AntFotoEvents::POST_PUBLISH, new FotoEvent($foto));
        		return $this->redirect($this->generateUrl('album'), 301);
    		}
    	}
    	return array('form' => $form->createView());
    }
    
    
    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAction(Foto $foto){
    	
    	$em = $this->get('doctrine')->getEntityManager();    	
    	$em->remove($foto);
    	$em->flush();
		
		return array("estado" => "eliminado");
    }
}