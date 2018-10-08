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
	$file = new FileClass($_FILES['file'],$_POST['commentary']);
	$mapper = new FileMapper();
	$error = UploadHelper::saveFile($file, $mapper, DirectoryHelper::getUploadDirectory());	
	var_dump($error);
});
$app->get('/{filename}', function ($request, $response, array $args) {
	//$response = $this -> view -> render($response,'home.phtml');
	$filename = $args['filename'];
	$mapper = new FileMapper();
    var_dump($mapper -> searchFile('name', $filename));
});

$app->run();