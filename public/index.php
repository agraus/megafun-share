<?php
require "../vendor/autoload.php" ;
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];
$app = new \Slim\App($config);
unset($app->getContainer()['errorHandler']);
unset($app->getContainer()['phpErrorHandler']);
$container = $app -> getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("templates/");


$app->get('/', function ($request, $response) {
	$response = $this -> view -> render($response,'home.phtml');
    return $response;
});
$app->post('/', function ($request, $response) {
	$file = new FileClass($_FILES['file']);
	$error = UploadHelper::saveFile($file, DirectoryHelper::getUploadDirectory());	
	var_dump($error);
});

$app->run();