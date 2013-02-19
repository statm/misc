<?php
	function decodeURL($str)
	{
		$I = null;
		$A = (int)($str{0});
		$B = substr($str, 1);
		$C = floor(strlen($B) / $A);
		$D = strlen($B) % $A;
		$E = array();
		$F = 0;
		
		while ($F < $D)
		{
			if (!isset($E[$F]))
			{
				$E[$F] = "";
			}
			$E[$F] = substr($B, ($C + 1) * $F, ($C + 1));
			$F ++;
		}
		$F = $D;
		while ($F < $A)
		{
			$E[$F] = substr($B, ($C * ($F - $D) + ($C + 1) * $D), $C);
			$F ++;
		}
		
		$G = "";
		$F = 0;
		while ($F < strlen($E[0]))
		{
			$I = 0;
			while ($I < count($E))
			{
				if ($F < strlen($E[$I]))
				{
					$G = $G . $E[$I][$F];
				}
				$I ++;
			}
			$F ++;
		}
		
		$G = htmlspecialchars(urldecode($G));
		$G = str_replace("^", "0", $G);
		$G = str_replace("+", " ", $G);
		
		return $G;
	}
	
	function getAlbumIdByURL($url)
	{
		$urlParts = explode("/", explode("#", $url)[0]);
		return $urlParts[count($urlParts) - 1];
	}
	
	function getPlaylistByAlbumURL($url)
	{
		$albumId = getAlbumIdByURL($url);
		return simplexml_load_file("http://www.xiami.com/song/playlist/id/".$albumId."/type/1");
	}
?>