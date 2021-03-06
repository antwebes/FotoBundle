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
    	$em = $this->getDoctrine()->getManager();
    	$components = $em->getRepository('AntFotoBundle:FotoComponent')->findComponent($id);
    	$object = array();
    	foreach ( $components as $c){
    		$component = $c->getComponent();
    		$model = $component->getModel();
    		$identifier = $component->getIdentifier();
    		$object[] = $this->getDoctrine()->getRepository($model)->findOneById($identifier);
    	}
        return array('foto' => $foto, 'usuarios' => $object);
    }
    /**
     * @Rest\View
     */
    public function fotoPathAction($path)
    {
    	return array('path' => $path);
    }
    
    
    /**
     * @Rest\View
     */
    public function editarAction($id) {
    	
	    	$fotoManager = $this->get('ant_foto.foto_manager');
	    	$foto = $fotoManager->findFotoBy(array('id'=>$id));
    		$request = $this->getRequest();

    		$em = $this->getDoctrine()->getManager();
    		$foto->setTitulo(htmlspecialchars($request->get("titulo")));
    		$em->persist($foto);
    		$em->flush();  
    	
    	return array('foto' => $foto);
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
        		//fotoComponent
        		//$usuario = $this->get('ant_foto.user_manager')->findUserBy(array('id'=>2));
        		//$usuario = $em->getRepository('UsuarioBundle:User')->findOneById(2);
        		//$fotoManager = $this->get('ant_foto.action_manager.orm');
        		//$subject       = $fotoManager->findOrCreateComponent($usuario);
        		//$foto = $fotoManager->create($foto, 'foto', array('directComplement' => $usuario, 'indirectComplement' => $u ));
        		//$fotoManager->updateAction($foto);
        		//fin FotoComponent
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
    public function labelAction($id, $userId){
    	
    	//Yo debo crear el componente si es que no existe
    	//Asignar a esta foto ese componente
    	
    	$em = $this->getDoctrine()->getManager();
    	$foto = $em->getRepository('FotoBundle:Foto')->findOneById($id);
    	$usuario = $this->get('ant_foto.user_manager')->findUserBy(array('username'=>$userId));
    	$fotoManager = $this->get('ant_foto.abstract_foto_manager.orm');
    	$foto = $fotoManager->create($foto, 'foto', array('directComplement' => $usuario));
    	$fotoManager->updateAction($foto);
    	
    	return array("estado" => "etiquetado");
    }
    
    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAction($id){
    	$fotoManager = $this->get('ant_foto.foto_manager');
    	$foto = $fotoManager->findFotoBy(array('id'=>$id));
    	$em = $this->get('doctrine')->getEntityManager();    	
    	$em->remove($foto);
    	$em->flush();
		
		return array("estado" => "eliminado");
    }
}