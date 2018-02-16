<?php
use \Hcode\Page;


$app->get('/', function() { # / se não passar nada na URL chame a rota padrão
	    
		$page = new Page();

		$page->setTpl("index");

	});


?>