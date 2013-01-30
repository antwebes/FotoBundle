<?php

namespace ant\FotoBundle\Controller;

use chatea\FotoBundle\Form\FotoType;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use chatea\FotoBundle\Entity\Foto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use ant\SocialBundle\Model\NotificacionInterface;

//use para probar el badgeBundle con eventos
use ant\BadgeBundle\Event\BadgeEvent;
use ant\BadgeBundle\Event\AntBadgeEvents;

class FotoController extends Controller
{
	/**
	 * @Rest\View
	 */
    public function indexAction(Foto $foto)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$dispatcher = $this->container->get('event_dispatcher');
    	$event = new BadgeEvent($em, 'chatea\ChatBundle\Entity\Sala');
    	$dispatcher->dispatch(AntBadgeEvents::POST_PUBLISH, $event);
    	/*
    	$u = $this->get('security.context')->getToken()->getUser();
    	$composer = $this->get('ant_badge.composer');
    	
    	$rank = $composer->newRank()
    	->setcount(3)
    	->setParticipant($u)
    	//->setAcquired(true)
    	->setWonAt(new \DateTime('now'))
    	->getRank();/*
    	$rank->setcount(3);
    	$rank->setAcquired(1);
    	//$rank->setParticipant($u);
    	$rank->setWonAt(new \DateTime('now'));
    	//ldd($rank);*/
    	
    	
    	//$this->get('ant_badge.rank_manager')->saveRank($rank);
    	
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
    	$form = $this->get('form.factory')->create(new FotoType());
    	
    	if ($this->getRequest()->isMethod('POST')) {
    		$form->bind($this->getRequest());
    		if ($form->isValid()) {
    			$foto = $form->getData();
    			$em = $this->getDoctrine()->getManager();    			
    			$u = $this->get('security.context')->getToken()->getUser();
    			$this->get('ant_social.NotificacionManager')->crearNotificacion($u, NotificacionInterface::FOTO, $foto);
    			$foto->setUsuario($u);
    			$em->persist($foto);
        		$em->flush();
        		
        		//timeline
        		$this->get('ant_social.TimelineServicio')->crearAccion($u, 'foto', $foto);
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