<?php
/* Класс для обработки и сортировки метаданных 
загруженных файлов c последующим кодирование в JSON.
 Для получения данных используется getID3
*/
abstract class MetadataHelper
{
	/* Метод для создание в массива в котором хранятся
	все ключи и значения массива метаданныхю
	Сделан для сохранения порядка ключей при кодировании в JSON*/
	private static function wrapper(array $arr):string
	{
		$wrapper = [];
		$wrapper[0] = array_keys($arr);
		$wrapper[1] = array_values($arr);
		$result = json_encode($wrapper);
		return $result;
	}
	public static function getAudioMetadata(string $file)
	{
		$getID3 = new getID3();
		$file_info = $getID3 -> analyze($file);
		$tag = array_keys($file_info['tags']);
		$metadata = [
			'Format' => $file_info['fileformat'],
			'Bitrate' => $file_info['bitrate'],
			'Playtime' => $file_info['playtime_string'],
			'Title' => (isset($file_info['tags'][$tag[0]]['title'][0]))? $file_info['tags'][$tag[0]]['title'][0]:"Unknown",
			'Artist' => (isset($file_info['tags'][$tag[0]]['artist'][0]))? $file_info['tags'][$tag[0]]['artist'][0]:"Unknown",
			'Album' => (isset($file_info['tags'][$tag[0]]['album'][0]))? $file_info['tags'][$tag[0]]['album'][0]:"Unknown",
			'Year' => (isset($file_info['tags'][$tag[0]]['year'][0]))? $file_info['tags'][$tag[0]]['year'][0]:"Unknown",
			'Codec' => (isset($file_info['audio']['codec']))? $file_info['audio']['codec']:"Unknown",
			'Compression ratio' => (isset($file_info['audio']['comression_ratio']))? $file_info['audio']['comression_ratio']:"Unknown",
			'Encoder' => (isset($file_info['audio']['encoder']))? $file_info['audio']['encoder']:"Unknown"
		];
		return MetadataHelper::wrapper($metadata);
	}
	public static function getImageMetadata(string $file)
	{
		$getID3 = new getID3();
		$file_info = $getID3 -> analyze($file);
		$metadata = [
			'Format' => $file_info['fileformat'],
			'Width' => $file_info['video']['resolution_x'],
			'Height' => $file_info['video']['resolution_y']
		];
		return MetadataHelper::wrapper($metadata);
	}
	public static function getVideoMetadata(string $file)
	{
		$getID3 = new getID3();
		$file_info = $getID3 -> analyze($file);
		$metadata = [
			'Format' => $file_info['fileformat'],
			'Bitrate' => $file_info['bitrate'],
			'Playtime' => $file_info['playtime_string'],
			'Width' => $file_info['video']['resolution_x'],
			'Height' => $file_info['video']['resolution_y'],
			'Title' => (isset($file_info['tags'][$tag[0]]['title'][0]))? $file_info['tags'][$tag[0]]['title'][0]:"Unknown",
			'Year' => (isset($file_info['tags'][$tag[0]]['year'][0]))? $file_info['tags'][$tag[0]]['year'][0]:"Unknown",
			'Codec' => (isset($file_info['audio']['codec']))? $file_info['audio']['codec']:"Unknown",
			'Encoder' => (isset($file_info['audio']['encoder']))? $file_info['audio']['encoder']:"Unknown"
		];
		return MetadataHelper::wrapper($metadata);
	}
}