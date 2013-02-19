<?php
	// TC = transcode
	function TC($str)
	{
		$result = iconv("UTF-8", "GB2312", $str);
		
		$result = str_replace("?", "", $result);
		
		return $result;
	}
	
	function TU($str)
	{
		$result = iconv("GB2312", "UTF-8", $str);
		
		return $result;
	}
?>