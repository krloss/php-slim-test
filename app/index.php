<?php
require('../vendor/autoload.php');

$app = new \Slim\App();

$app->get('/ola/{nome}',function($req, $res, $args=[]) {
	$nome = $req->getAttribute('nome');

	$res->getBody()->write("Ola $nome");
	return $res;
});

$app->run();
?>
