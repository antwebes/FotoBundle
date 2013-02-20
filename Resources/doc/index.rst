FotoBundle
===========

Step3: Configuration 
-----------------------------------------

::
	
	ant_foto:
	    db_driver: orm
	    object_manager: doctrine.orm.entity_manager
	    
	    
app/config/routing.yml
	    
::
    ant_foto_bundle:
    resource: "@AntFotoBundle/Resources/config/routing.yml"
    
Basic Usage
===========

Recuperate the photos which has a usuario how component. You can include this code in your controller.
Return $f, the photos where user $u was labeled.

::

	$u = $this->get('ant_foto.user_manager')->findUserBy(array('id'=>$id));
	$fotoManager = $this->get('ant_foto.action_manager.orm');
	$f       = $fotoManager->labeled($u);