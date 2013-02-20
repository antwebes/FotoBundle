FotoBundle
===========

Step3: Configuration 
-----------------------------------------

::
	
	ant_foto:
	    db_driver: orm
	    object_manager: doctrine.orm.entity_manager
	    
::

app/config/routing.yml

    ant_foto_bundle:
    resource: "@AntFotoBundle/Resources/config/routing.yml"
    
Basic Usage
===========

Recuperate the photos which has a usuario how component.

::
    	$em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('UsuarioBundle:User')->findOneById(2);
        $fotoManager = $this->get('ant_foto.action_manager.orm');
       	$u       = $fotoManager->findOrCreateComponent($usuario);
        $f = $fotoManager->getQueryBuilderForComponent($u);
        