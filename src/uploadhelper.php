<?php
abstract class UploadHelper
{
	public static function saveFile(FileClass $file, FileMapper $mapper, array $directory)
	{
		$properties = $file -> getFileProperties();
		if(strlen($properties['name']) > 180)
		{
			return "Name can't be longer than 180 characters";
		}
		if($properties['size'] > 52428800)
		{
			return "Maximum size is 50M";
		}
		if(strstr($properties['type'], 'image'))
		{
			$directory['preview'] = self::makeFilePreview($properties['tmp_name'], $properties['type'], $properties['new_name'], $directory);
			$metadata = MetadataHelper::getImageMetadata($properties['tmp_name']);
		}
		if(strstr($properties['type'],'audio'))
		{
			$metadata = MetadataHelper::getAudioMetadata($properties['tmp_name']);
		}
		if(strstr($properties['type'],'video'))
		{
			$metadata = MetadataHelper::getVideoMetadata($properties['tmp_name']);
		}
		if(move_uploaded_file($properties['tmp_name'], $directory['file'] .$properties['new_name'] .'.txt'))
		{
			$mapper -> saveFile($file, $directory, $metadata);
			return 'File uploaded';
		}
		else
		{
			return"Upload failed";
		}
	}
	private static function makeFilePreview(string $file, string $type, string $filename, array $directory)
	{
		$width = 800;
		$height = 600;
		switch($type)
		{
    		case 'image/bmp': $image = imagecreatefrombmp($file); break;
    		case 'image/gif': $image = imagecreatefromgif($file);  break;
   		 	case 'image/jpeg': $image = imagecreatefromjpeg($file); break;
   			case 'image/png': $image = imagecreatefrompng($file); break;
   			default : return NULL;
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
    		case 'image/bmp': $path = $directory['preview'] .$filename .'.bmp'; imagewbmp($image_preview, $path); break;
    		case 'image/gif': $path = $directory['preview'] .$filename .'.gif'; imagegif($image_preview,  $path); break;
    		case 'image/jpeg': $path = $directory['preview'] .$filename .'.jpg'; imagejpeg($image_preview,  $path); break;
    		case 'image/png': $path = $directory['preview'] .$filename .'.png'; imagepng($image_preview,  $path); break;
  		}
  		$path = explode('public/', $path);
  		$path = $path[1];
  		return $path;
	}
}