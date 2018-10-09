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
	try
	{
	$data = UploadHelper::saveFile($file, $mapper, DirectoryHelper::getUploadDirectory());	
	$response = $this -> view -> render($response,'success.phtml', $data);
	}
	catch(Exception $e)
	{
		$data[] = $e->getMessage();
		$response = $this -> view -> render($response,'home.phtml', $data);
	}
});
$app->get('/{filename}', function ($request, $response, array $args) {
	$filename = $args['filename'];
	$mapper = new FileMapper();
    $data = $mapper -> searchFile('name', $filename);
	if(!empty($data))
	{
    	$response = $this -> view -> render($response,'filepage.phtml', $data);
    }
    else
    {
    	echo "file not found"
    }
});

$app->run();