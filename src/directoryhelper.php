<?php
abstract class DirectoryHelper
{
	public static function getUploadDirectory():array
	{
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$directory = [];
		$directory['file'] = __DIR__ ."/../uploads/$year/$month/$day/";
		if(!is_dir($directory['file']))
		{
			mkdir($directory['file'],0777,true);
		}
		$directory['preview'] = __DIR__ ."/../public/previews/$year/$month/$day/";
		if(!is_dir($directory['preview']))
		{
			mkdir($directory['preview'],0777,true);
		}
		return $directory;
	}
}