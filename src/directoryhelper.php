<?php
abstract class DirectoryHelper
{
	static function getUploadDirectory():string
	{
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$directory = __DIR__ ."/../uploads/$year/$month/$day/";
		if(!is_dir($directory))
		{
			mkdir($directory,0777,true);
		}
		return $directory;
	}
}