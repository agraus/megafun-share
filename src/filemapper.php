<?php
class FileMapper
{
	private $dbinfo =  __DIR__ . "/../dbinfo_real.ini" ;
	private $mysqli;
	private function dbConnect()
	{
		$db = parse_ini_file($this -> dbinfo);
		$this -> mysqli = new mysqli($db['host'], $db['user'], $db['password'], $db['database']);
		if (mysqli_connect_errno()) 
		{
    		echo mysqli_connect_error();
    		exit();
		}
		$this -> mysqli -> set_charset('utf-8mb4');
	}
	public function saveFile(FileClass $file, string $path)
	{
		$properties = $file -> getFileProperties();
		$this -> dbConnect();
		$stmt = $this -> mysqli -> prepare(
			"INSERT INTO megafun 
			(orig_name, 
			name, 
			`path`, 
			mime_type, 
			upload_date
			)
			VALUES(?,?,?,?,CURRENT_TIMESTAMP())"
			);
		$stmt -> bind_param('ssss', $properties['name'], $properties['new_name'], $path, $properties['type']);
		$stmt -> execute();
		echo $this -> mysqli -> error;
		$this -> mysqli -> close() ;
	}
}