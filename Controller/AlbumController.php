<?php

namespace ant\FotoBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AlbumController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$u = $this->get('security.context')->getToken()->getUser();
    	$fotos = $em->getRepository('FotoBundle:Foto')->findFotosUsuario($u);
    	//ldd($fotos);
    	//if (!$fotos) throw new NotFoundHttpException();
        return $this->render('FotoBundle:Album:index.html.twig', array('fotos' => $fotos));
    }
    public function indexAmigoAction($username)
    {
    	$em = $this->getDoctrine()->getManager();
    	$u = $em->getRepository('UsuarioBundle:User')->findOneByUsername($username);
    	$fotos = $em->getRepository('FotoBundle:Foto')->findFotosUsuario($u);
    	return $this->render('FotoBundle:Album:indexAmigo.html.twig', array('fotos' => $fotos, 'usuario' => $u));
    }
   
}