<?php
function makeimage($filename,$newfilename,$path,$newwidth,$newheight) {
	$image_type = strstr($filename, '.');

		switch($image_type) {
			case '.jpg':
				$source = imagecreatefromjpeg($filename);
				break;
			case '.png':
				$source = imagecreatefrompng($filename);
				break;
			case '.gif':
				$source = imagecreatefromgif($filename);
				break;
			default:
				echo("Error Invalid Image Type");
				die;
				break;
			}
	$imgsize = getimagesize($filename);
	$imgwidth = $imgsize[0];
	$imgheight =$imgsize[1];
	if($imgwidth<100 and $imgheight<100)
	{	
		$newwidth = $imgwidth;
		$newheight = $imgheight;
	}
	$file = $newfilename;
	$fullpath = $path . $file;
	list($width, $height) = getimagesize($filename);
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagejpeg($thumb, $fullpath,60);
	$filepath = $fullpath;
	return $filepath;
	exit;
}

?> 