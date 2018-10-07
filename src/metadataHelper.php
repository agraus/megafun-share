<?php
abstract class MetadataHelper
{
	public static function getAudioMetadata(string $file)
	{
		$getID3 = new getID3();
		$file_info = $getID3 -> analyze($file);
		$tag = array_keys($file_info['tags']);
		$metadata = [
			'fileformat' => $file_info['fileformat'],
			'bitrate' => $file_info['bitrate'],
			'playtime' => $file_info['playtime_string'],
			'title' => $file_info['tags'][$tag[0]]['title'],
			'artist' => $file_info['tags'][$tag[0]]['artist'],
			'album' => $file_info['tags'][$tag[0]]['album'],
			'year' => $file_info['tags'][$tag[0]]['year'],
			'codec' => $file_info['audio']['codec'],
			'compression_ratio' => $file_info['audio']['compression_ratio'],
			'encoder' => $file_info['audio']['encoder']
		];
		return json_encode($metadata);
	}
	public static function getImageMetadata(string $file)
	{
		$getID3 = new getID3();
		$file_info = $getID3 -> analyze($file);
		$metadata = [
			'fileformat' => $file_info['fileformat'],
			'resolution_x' => $file_info['video']['resolution_x'],
			'resolution_y' => $file_info['video']['resolution_y']
		];
		return json_encode($metadata);
	}
}