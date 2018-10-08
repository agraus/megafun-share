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
	public function saveFile(FileClass $file, array $directory, $metadata)
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
		$this -> mysqli -> close();
	}
	public function searchFile(string $column, string $needle)
	{
		$this -> dbConnect();
		$stmt = $this -> mysqli -> prepare("SELECT * FROM megafun WHERE " .$column ." LIKE ? ORDER BY file_id DESC");
		$stmt -> bind_param('s', $needle);
		$stmt -> execute();
		$stmt->bind_result($col1, $col2, $col3 ,$col4 , $col5, $col6, $col7, $col8, $col9);
		$properties = [];
		while($stmt -> fetch())
		{
			$properties[] = [
				'file_id' => $col1,
				'orig_name' => $col2,
				'name' => $col3,
				'path' => $col4,
				'preview_path' => $col5,
				'mime_type' => $col6,
				'metadata' => $col7,
				'commentary' => $col8,
				'timestamp' => $col9
			];
		}
		$this -> mysqli -> close();
		return $properties;
	}
}