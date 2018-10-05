<?php
abstract class UploadHelper
{
	public static function saveFile(array $file, string $directory)
	{
		$tmp_name = $file['tmp_name'];
		$name = $file['name'];
		$size = $file['size'];
		if(strlen($name) > 180)
		{
			return "Name can't be longer than 180 characters";
		}
		if($file['type'] = 'image/png')
		{
			return self::makeFilePreview($tmp_name);
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
	private static function makeFilePreview(string $file)
	{
		$width = 800;
		$height = 600;
		list($width_orig, $height_orig) = getimagesize($file);
		$ratio_orig = $width_orig/$height_orig;
		if ($width/$height > $ratio_orig) 
		{
   			$width = $height*$ratio_orig;
		}	 
		else
		{
   			$height = $width/$ratio_orig;
		}
		$image_preview = imagecreatetruecolor($width, $height);
		$image = imagecreatefrompng($file);
		imagecopyresampled($image_preview, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		$image_preview = imagepng($image_preview, __DIR__ ."/../public/image.png", 0);
		return $image_preview;
	}
}