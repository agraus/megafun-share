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
	$success = UploadHelper::saveFile($file, $mapper, DirectoryHelper::getUploadDirectory());	
	$response = $this -> view -> render($response,'home.phtml', ['success' => $success]);
	}
	catch(Exception $e)
	{
		$error[] = $e->getMessage();
		$response = $this -> view -> render($response,'home.phtml', ['error' => $error]);
	}
});
$app->get('/{filename}', function ($request, $response, array $args) {
	$filename = $args['filename'];
	$mapper = new FileMapper();
    $properties = $mapper -> searchFile('name', $filename);
	if(!empty($properties))
	{
    	$response = $this -> view -> render($response,'home.phtml', ['properties' => $properties]);
    }
    else
    {
    	$response = $this -> view -> render($response,'home.phtml',['not_found' => 1]);
    }
});
$app->post('/{filename}', function ($request, $response, array $args) {
	$filename = $args['filename'];
	$mapper = new FileMapper();
    $data = $mapper -> searchFile('name', $filename);
	if(!empty($data))
	{
		$file = $data[0]['path'] .$data[0]['name'] .'.txt';
		if(file_exists($file))
		{
			header('Content-Description: File Transfer');
    		header('Content-Type: ' .$data[0]['mime_type']);
    		header('Content-Disposition: attachment; filename="'.$data[0]['orig_name'].'"');
    		header('Expires: 0');
    		header('Cache-Control: must-revalidate');
    		header('Pragma: public');
    		header('Content-Length: ' .filesize($file));
    		readfile($file);
		}
	}

});
$app->run();