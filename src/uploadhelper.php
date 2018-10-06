<?php
abstract class UploadHelper
{
	public static function saveFile(array $file, string $directory)
	{
		$tmp_name = $file['tmp_name'];
		$name = $file['name'];
		$size = $file['size'];
		$type = $file['type'];
		if(strlen($name) > 180)
		{
			return "Name can't be longer than 180 characters";
		}
		$new_name = random_int(1, 9999999999);
		if(strstr($file['type'], 'image'))
		{
			self::makeFilePreview($tmp_name, $type, $new_name);
		}
		if(move_uploaded_file($tmp_name, $directory .$new_name .'.txt'))
		{
			$db_array = [
				'orig_name' => $name,
				'name' => $new_name,
				'path' => $directory,
				'mime_type' => $type
				];
			return $db_array;
		}
		else
		{
			return"Upload failed";
		}
	}
	private static function makeFilePreview(string $file, string $type, string $filename)
	{
		$width = 800;
		$height = 600;
		switch($type)
		{
    		case 'image/bmp': $image = imagecreatefromwbmp($file); break;
    		case 'image/gif': $image = imagecreatefromgif($file); break;
   		 	case 'image/jpeg': $image = imagecreatefromjpeg($file); break;
   			case 'image/png': $image = imagecreatefrompng($file); break;
 		}
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
		if($type == "image/gif" or $type == "image/png")
		{
    		imagecolortransparent($image_preview, imagecolorallocatealpha($image_preview, 0, 0, 0, 127));
    		imagealphablending($image_preview, false);
    		imagesavealpha($image_preview, true);
  		}
		imagecopyresampled($image_preview, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		switch($type)
		{
    		case 'image/bmp': imagewbmp($image_preview, __DIR__ ."/../public/previews/" .$filename .'.bmp'); break;
    		case 'image/gif': imagegif($image_preview,  __DIR__ ."/../public/previews/" .$filename .'.gif'); break;
    		case 'image/jpeg': imagejpeg($image_preview,  __DIR__ ."/../public/previews/" .$filename .'.jpg'); break;
    		case 'image/png': imagepng($image_preview,  __DIR__ ."/../public/previews/" .$filename .'.png'); break;
  		}
	}
}