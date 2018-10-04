<?php
require "../vendor/autoload.php" ;
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];

$app = new \Slim\App($config);
$container = $app -> getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("templates/");


$app->get('/', function ($request, $response) {
	$response = $this -> view -> render($response,'home.phtml');
    return $response;
});

$app->run();