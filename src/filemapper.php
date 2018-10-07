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
	public function saveFile(FileClass $file, array $directory, string $metadata)
	{
		$properties = $file -> getFileProperties();
		if(!strstr($properties['type'], 'image'))
		{
			$directory['preview'] = NULL;
		}
		$this -> dbConnect();
		$stmt = $this -> mysqli -> prepare(
			"INSERT INTO megafun 
			(orig_name, 
			name, 
			`path`,
			preview_path, 
			mime_type,
			metadata,
			commentary, 
			upload_date
			)
			VALUES(?,?,?,?,?,?,?,CURRENT_TIMESTAMP())"
			);
		$stmt -> bind_param('sssssss', $properties['name'], $properties['new_name'], $directory['file'],$directory['preview'], $properties['type'], $metadata, $properties['commentary']);
		$stmt -> execute();
		echo $this -> mysqli -> error;
		$this -> mysqli -> close() ;
	}
}