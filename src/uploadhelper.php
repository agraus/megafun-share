<?php
abstract class UploadHelper
{
	public static function saveFile(FileClass $file, string $directory)
	{
		$properties = $file -> getFileProperties();
		if(strlen($properties['name']) > 180)
		{
			return "Name can't be longer than 180 characters";
		}
		if(strstr($properties['type'], 'image'))
		{
			self::makeFilePreview($properties['tmp_name'], $properties['type'], $properties['new_name']);
		}
		if(move_uploaded_file($properties['tmp_name'], $directory .$properties['new_name'] .'.txt'))
		{
			return 'File uploaded';
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
    		case 'image/bmp': $image = imagecreatefrombmp($file); break;
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