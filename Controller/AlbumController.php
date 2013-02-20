<?php

namespace ant\FotoBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AlbumController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$u = $this->get('security.context')->getToken()->getUser();
    	$fotos = $em->getRepository('FotoBundle:Foto')->findFotosUsuario($u);
    	//if (!$fotos) throw new NotFoundHttpException();
        return $this->render('AntFotoBundle:Album:index.html.twig', array('fotos' => $fotos));
    }
    public function indexAmigoAction($username)
    {
    	$em = $this->getDoctrine()->getManager();
    	$u = $em->getRepository('UsuarioBundle:User')->findOneByUsername($username);
    	$fotos = $em->getRepository('FotoBundle:Foto')->findFotosUsuario($u);
    	return $this->render('AntFotoBundle:Album:indexAmigo.html.twig', array('fotos' => $fotos, 'usuario' => $u));
    }
    /**
     * @Template
     */
    public function labeledAction($id)
    {
    	$u = $this->get('ant_foto.user_manager')->findUserBy(array('id'=>$id));
    	//$usuario = $em->getRepository('UsuarioBundle:User')->findOneById(2);
    	$fotoManager = $this->get('ant_foto.action_manager.orm');
    	$f       = $fotoManager->labeled($u);
    	return array('fotos'=>$f);
    }   
}