<?php
require('../vendor/autoload.php');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "toor";
$config['db']['dbname'] = "test_slim";

$app = new \Slim\App(['settings'=>$config]);
$container = $app->getContainer();

$container['db'] = function($self) {
	$db = $self['settings']['db'];
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname]",$db['user'],$db['pass']);

	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	return $pdo;
};

$app->get('/ola/{nome}',function($req, $res, $args=[]) {
	$nome = $req->getAttribute('nome');

	$res->getBody()->write("Ola $nome");
	return $res;
});

$app->get('/lista',function($req, $res, $args=[]) {
	$query = $this->db->prepare("SELECT * FROM questao");

	$query->execute();
	return $res->withJson(json_encode($query->fetchAll()));
});

$app->run();
?>
