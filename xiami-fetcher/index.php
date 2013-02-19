<?php
	include_once("include/url_utils.php");
	include_once("include/fetch_utils.php");
	
	if (isset($_REQUEST["albumurl"]))
	{
		header("Location: ".fetchPlaylist(getPlaylistByAlbumURL($_REQUEST["albumurl"])));
	}
?>

<!-- HTML -->
<!DOCTYPE html>
<html>
	<head>
		<title>虾米专辑下载</title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<style>
			input[type="text"]
			{
			outline: none !important;
			box-shadow:none !important;
			}
		</style>
	</head>
	
	<body>
		<form action="./" target="_blank" method="post" style="margin:20px 15px;">
			<div class="input-append">
				<input type="text" name="albumurl" placeholder="专辑 URL" spellcheck="false" style="width:300px;" onclick="this.select();"/>
				<button type="submit" class="btn btn-primary">下载</button>
			</div>
		</form>
	</body>
	
	<script src="bootstrap/js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</html>