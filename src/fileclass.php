<?php
/*Класс, хранящий информацию о файле из $_FILES и $_POST
для последющей передачи в БД */
class FileClass
{
	private $name;
	private $new_name;
	private $size;
	private $type;
	private $tmp_name;
	private $commentary;
	public function __construct(array $file, string $commentary)
	{
		$this -> name = $file['name'];
		$this -> new_name = random_int(1, 9999999999);
		$this -> size = $file['size'];
		$this -> type = $file['type'];
		$this -> tmp_name = $file['tmp_name'];
		$this -> commentary = trim($commentary);
	}
	public function getFileProperties():array
	{
		$array = [
			'name' => $this -> name,
			'new_name' => $this -> new_name,
			'size' => $this -> size,
			'type' => $this -> type,
			'tmp_name' => $this -> tmp_name,
			'commentary' => $this -> commentary
		];
		return $array;
	}
}