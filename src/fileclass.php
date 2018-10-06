<?php
class FileClass
{
	private $name;
	private $new_name;
	private $size;
	private $type;
	private $tmp_name;
	public function __construct(array $file)
	{
		$this -> name = $file['name'];
		$this -> new_name = random_int(1, 9999999999);
		$this -> size = $file['size'];
		$this -> type = $file['type'];
		$this -> tmp_name = $file['tmp_name'];
	}
	public function getFileProperties():array
	{
		$array = [
			'name' => $this -> name,
			'new_name' => $this -> new_name,
			'size' => $this -> size,
			'type' => $this -> type,
			'tmp_name' => $this -> tmp_name
		];
		return $array;
	}
}