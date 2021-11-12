<?php

function InclureClasses($classname)
{

	// La constante magique __DIR__ retourne Le dossier du fichier.
	if(file_exists($file = __DIR__. '/' . $classname . '.php'))
	{
		require $file;
	}
}

spl_autoload_register('InclureClasses');

?>