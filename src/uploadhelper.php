<?php
abstract class UploadHelper
{
	public static function saveFile(array $file, string $directory)
	{
		$tmp_name = $file['tmp_name'];
		$name = $file['name'];
		$size = $file['size'];
		if(strlen($name) > 60)
		{
			return "Name can't be longer than 30 characters";
		}
		$new_name = random_int(1, 9999999) .'.' .pathinfo($name, PATHINFO_EXTENSION);
		if(move_uploaded_file($tmp_name, $directory .$new_name))
		{
			return "File uploaded";
		}
		else
		{
			return"Upload failed";
		}
	}
}