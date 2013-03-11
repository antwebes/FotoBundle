<?php 

namespace sdfs\sdfsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use sdfs\sdfsBundle\Entity\User;
use sdfs\sdfsBundle\Entity\Comment; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ComentarioFotoController extends Controller
{	
	public function ultimoComentarioAction(){
		$em = $this->get('doctrine')->getEntityManager();
		$comentarios = $em->getRepository('sdfsBundle:Comment')->findUltimoComentario();
		return ($this->render('sdfsBundle:Comentario:listado.html.twig', array(
				'items'=>$comentarios
		)));
	}
	
	/**
	 * @Template
	 */
	public function comentarioAction($id)
	{
		$thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
		if (null === $thread) {
			$thread = $this->container->get('fos_comment.manager.thread')->createThread();
			$thread->setId($id);
			$thread->setPermalink($this->get('request')->getUri());
	
			// Add the thread
			$this->container->get('fos_comment.manager.thread')->saveThread($thread);
		}
		$comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
		 
		$response = $this->render('sdfsBundle:Comentario:comentario.html.twig' , array(
				'comments' => $comments,
				'thread' => $thread,
		));	
		$response->setSharedMaxAge(600);
		$response->setPublic();
	
		return $response;
	}
}