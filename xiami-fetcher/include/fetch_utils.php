<?php
	include_once("encoding_utils.php");
	include_once("url_utils.php");
	
	function fetchPlaylist($listXML)
	{
		$jobId = uniqid();
		mkdir("./fetched/".$jobId);
		
		$albumName = TC((string)$listXML->trackList->track[0]->album_name);
		$zipPath = "./fetched/".$jobId."/".$albumName.".zip";
		$zip = new ZipArchive();
		$zip->open($zipPath, ZIPARCHIVE::CREATE);
		
		$i = 1;
		foreach ($listXML->trackList->track as $trackXML)
		{
			$fetchResult = fetchTrack($trackXML, $jobId, $i);
			$zip->addFile($fetchResult["trackPath"], $fetchResult["trackZipPath"]);
			$i ++;
		}
		
		$zip->close();
		
		return TU($zipPath);
	}
	
	function fetchTrack($trackXML, $jobId, $index)
	{
		$artistName = TC((string)$trackXML->artist);
		$trackName = TC((string)$trackXML->title);
		$albumName = TC((string)$trackXML->album_name);
		$url = decodeURL((string)$trackXML->location);
		
		$trackDir = "./fetched/".$jobId."/".$albumName;
		if (!file_exists($trackDir))
		{
			mkdir($trackDir);
		}
		
		$trackPath = $trackDir."/".$artistName." - ".$trackName.".mp3";
		downloadFile($url, $trackPath);
		
		// $id3Data = array(
			// "title" => $trackName,
			// "artist" => $artistName,
			// "album" => $albumName,
			// "track" => $index);
		// id3_set_tag($trackPath, $id3Data, ID3_V1_1);
		
		$trackZipPath = $albumName."/".$artistName." - ".$trackName.".mp3";
		return array("trackPath" => $trackPath, "trackZipPath" => $trackZipPath);
	}
	
	function downloadFile($url, $path)
	{
		$newfname = $path;
		$file = fopen ($url, "rb");
		if ($file) 
		{
			$newf = fopen ($newfname, "wb");
			
			if ($newf)
			while(!feof($file))
			{
				fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8);
			}
		}
		
		if ($file)
		{
			fclose($file);
		}
		
		if ($newf)
		{
			fclose($newf);
		}
	}
?>