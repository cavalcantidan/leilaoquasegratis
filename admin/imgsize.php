<?php
	
	function productimage($logo,$pid,$logo_temp)
	{
		$imagename = $logo;
		$imgname = "";//$time."_".$imagename.".jpg";
		$imgthumbname = "";

		$dest = "../uploads/products/thumbs/";
		$dest1 = "../uploads/products/thumbs_big/";
//		$dest2 = "images/products/thumbs_small/";
		$maindest = "../uploads/products/";
		$popupdest = "../uploads/products/popup/";
		ImageResizeMain($logo_temp,$maindest,$imagename);
		ImageResizenew($logo_temp,$dest,'thumb_'.$imagename);
		ImageResizenewBig($logo_temp,$dest1,'thumbbig_'.$imagename);
//		ImageResizenewSmall($logo_temp,$dest2,'thumbsmall_'.$imagename);
		ImageResizePopUp($logo_temp,$popupdest,'popup_'.$imagename);
		$imgname = $imagename;
		$imgthumbname = 'thumb_'.$imagename;
		$imgpopup = "popup_".$imagename;
	}



		function productimage1($logo,$pid)
		{
			//$logo;
			//exit;
			
			if($logo==1)
			{
				if (isset($_FILES["image"]) && $_FILES["image"]["name"] && preg_match('/\.(jpg|jpeg|gif|jpe|pcx|bmp)$/i', $_FILES["image"]["name"])) //upload category thumbnail
				{
		
						$time = time();
						$imagename = $time."_".$_FILES["image"]["name"];
						$imgname = "";//$time."_".$imagename.".jpg";
						$imgthumbname = "";
					if(file_exists($_FILES['image']['tmp_name']))
					{
						
						//copy($_FILES['image']['tmp_name'],"images/products/".$imagename);
						$dest = "../uploads/products/thumbs/";
						$maindest = "../uploads/products/";
						$popupdest = "../uploads/products/popup/";
						ImageResizeMain($_FILES['image']['tmp_name'],$maindest,$imagename);
						ImageResizenew($_FILES['image']['tmp_name'],$dest,'thumb_'.$imagename);
						ImageResizePopUp($_FILES['image']['tmp_name'],$popupdest,'popup_'.$imagename);
						$imgname = $imagename;
						$imgthumbname = 'thumb_'.$imagename;
						$imgpopup = "popup_".$imagename;
					}
					if($pid!="")
					{
						mysql_query("UPDATE products SET picture='".$imgname."',picture_thumb='".$imgthumbname."',picture_popup='".$imgpopup."' WHERE productID='$pid'") or die (mysql_error());
					
					}
				} 
			} 
		}
//header ("Content-type: image/jpeg");
/*
JPEG / PNG Image Resizer
Parameters (passed via URL):

img = path / url of jpeg or png image file

percent = if this is defined, image is resized by it's
          value in percent (i.e. 50 to divide by 50 percent)

w = image width

h = image height

constrain = if this is parameter is passed and w and h are set
            to a size value then the size of the resulting image
            is constrained by whichever dimension is smaller

Requires the PHP GD Extension

Outputs the resulting image in JPEG Format

By: Michael John G. Lopez - www.sydel.net
Filename : imgsize.php
*/
function ImageResize($img,$w,$h,$dest,$filename)
{
	//$img = $_GET['img'];
	//$percent = $_GET['percent'];
	/*$constrain = $_GET['constrain'];
	$w = $_GET['w'];
	$h = $_GET['h'];*/
	//Copy Org Image To Destination
	//@copy($img,$dest.'/'.$filename);
	
	
	// get image size of img
	$x = @getimagesize($img);
	// image width
	$sw = $x[0];
	// image height
	$sh = $x[1];
	
	if ($percent > 0) {
		// calculate resized height and width if percent is defined
		$percent = $percent * 0.01;
		$w = $sw * $percent;
		$h = $sh * $percent;
	} else {
		if (isset ($w) AND !isset ($h)) {
			// autocompute height if only width is set
			$h = (100 / ($sw / $w)) * .01;
			$h = @round ($sh * $h);
		} elseif (isset ($h) AND !isset ($w)) {
			// autocompute width if only height is set
			$w = (100 / ($sh / $h)) * .01;
			$w = @round ($sw * $w);
		} elseif (isset ($h) AND isset ($w) AND isset ($constrain)) {
			// get the smaller resulting image dimension if both height
			// and width are set and $constrain is also set
			$hx = (100 / ($sw / $w)) * .01;
			$hx = @round ($sh * $hx);
	
			$wx = (100 / ($sh / $h)) * .01;
			$wx = @round ($sw * $wx);
	
			if ($hx < $h) {
				$h = (100 / ($sw / $w)) * .01;
				$h = @round ($sh * $h);
			} else {
				$w = (100 / ($sh / $h)) * .01;
				$w = @round ($sw * $w);
			}
		}
	}
	
	$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG ($img) or // or PNG Image
	$im = @ImageCreateFromGIF ($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	
	if (!$im) {
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		readfile ($img);
	} else {
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($w, $h);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $w, $h, $sw, $sh);
		//@imagecopyresized($this->dest_image, $this->src_image, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		// Output resized image
		@ImageJPEG ($thumb,$dest.'/'.$filename);
		//if($thumb)copy($thumb,'thumb_'.$filename);
	}
}

function ImageResizenew($img,$dest,$filename)
{
	//$img = $_GET['img'];
	//$percent = $_GET['percent'];
	/*$constrain = $_GET['constrain'];
	$w = $_GET['w'];
	$h = $_GET['h'];*/
	//Copy Org Image To Destination
	//@copy($img,$dest.'/'.$filename);
	
	$sh = 0;
	$sw = 0;
	$wi = 0;
	// get image size of img
	$x = @getimagesize($img);
	// image width
	$sw += $x[0];
	//echo $sw;
	
	// image height
	$sh = $x[1];
	//echo "===".$sh;
	//exit;
	$mi = 98*100;
	
	if($sw >= 80)
	{
		//echo "Width Greater Than 300<br>";
		//$wi =$mi/$sw;
		//$shfinal = ceil(($sh*$wi)/100);
		//$shfinal = 98;
		$swfinal = 80 ; 
	}
	if($sh >= 60)
	{
		//echo "height Greater Than 300<br>";
		//echo $mi."====".$sh."<br>";
		//$wi = $mi/$sh;
		//echo $wi."<br>";
		
		//$swfinal = ceil(($sw*$wi)/100);
		$shfinal = 60 ;
		//$swfinal = 98 ; 
		//echo $swfinal;
		//exit;
	}
	//else
	//{
		//echo "Both not Greater Than 300<br>";
		//$wi = $mi/$sw;
		//$shfinal = ceil(($wi*$sh)/100);
		if($sw < 80)
		{
			$swfinal = $sw ;	
		}
		if($sh < 60)
		{
			$shfinal = $sh ;
		}	
		
	//}
	
	//echo "Width:-".$swfinal." Orignal Width:-".$sw."<br>";
	//echo "Height:-".$shfinal." Orignal Height:-".$sh."<br>";
	//echo "Wi:-".$wi."<br>";
	//exit;
		
	$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG ($img) or // or PNG Image
	$im = @ImageCreateFromGIF ($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	if (!$im) {
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		readfile ($img);
	} else {
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($swfinal, $shfinal);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $swfinal, $shfinal, $sw, $sh);
		//@imagecopyresized($this->dest_image, $this->src_image, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		// Output resized image
		@ImageJPEG ($thumb,$dest.'/'.$filename);
		//if($thumb)copy($thumb,'thumb_'.$filename);
	}
}

function ImageResizenewBig($img,$dest,$filename)
{
	//$img = $_GET['img'];
	//$percent = $_GET['percent'];
	/*$constrain = $_GET['constrain'];
	$w = $_GET['w'];
	$h = $_GET['h'];*/
	//Copy Org Image To Destination
	//@copy($img,$dest.'/'.$filename);
	
	$sh = 0;
	$sw = 0;
	$wi = 0;
	// get image size of img
	$x = @getimagesize($img);
	// image width
	$sw += $x[0];
	//echo $sw;
	
	// image height
	$sh = $x[1];
	//echo "===".$sh;
	//exit;
	$mi = 98*100;
	
	if($sw >= 120)
	{
		//echo "Width Greater Than 300<br>";
		//$wi =$mi/$sw;
		//$shfinal = ceil(($sh*$wi)/100);
		//$shfinal = 98;
		$swfinal = 120; 
	}
	if($sh >= 90)
	{
		//echo "height Greater Than 300<br>";
		//echo $mi."====".$sh."<br>";
		//$wi = $mi/$sh;
		//echo $wi."<br>";
		
		//$swfinal = ceil(($sw*$wi)/100);
		$shfinal = 90 ;
		//$swfinal = 98 ; 
		//echo $swfinal;
		//exit;
	}
	//else
	//{
		//echo "Both not Greater Than 300<br>";
		//$wi = $mi/$sw;
		//$shfinal = ceil(($wi*$sh)/100);
		if($sw < 120)
		{
			$swfinal = $sw ;	
		}
		if($sh < 90)
		{
			$shfinal = $sh ;
		}	
		
	//}
	
	//echo "Width:-".$swfinal." Orignal Width:-".$sw."<br>";
	//echo "Height:-".$shfinal." Orignal Height:-".$sh."<br>";
	//echo "Wi:-".$wi."<br>";
	//exit;
		
	$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG ($img) or // or PNG Image
	$im = @ImageCreateFromGIF ($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	if (!$im) {
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		readfile ($img);
	} else {
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($swfinal, $shfinal);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $swfinal, $shfinal, $sw, $sh);
		//@imagecopyresized($this->dest_image, $this->src_image, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		// Output resized image
		@ImageJPEG ($thumb,$dest.'/'.$filename);
		//if($thumb)copy($thumb,'thumb_'.$filename);
	}
}

function ImageResizenewSmall($img,$dest,$filename)
{
	//$img = $_GET['img'];
	//$percent = $_GET['percent'];
	/*$constrain = $_GET['constrain'];
	$w = $_GET['w'];
	$h = $_GET['h'];*/
	//Copy Org Image To Destination
	//@copy($img,$dest.'/'.$filename);
	
	$sh = 0;
	$sw = 0;
	$wi = 0;
	// get image size of img
	$x = @getimagesize($img);
	// image width
	$sw += $x[0];
	//echo $sw;
	
	// image height
	$sh = $x[1];
	//echo "===".$sh;
	//exit;
	$mi = 98*100;
	
	if($sw >= 100)
	{
		//echo "Width Greater Than 300<br>";
		//$wi =$mi/$sw;
		//$shfinal = ceil(($sh*$wi)/100);
		//$shfinal = 98;
		$swfinal = 100 ; 
	}
	if($sh >= 65)
	{
		//echo "height Greater Than 300<br>";
		//echo $mi."====".$sh."<br>";
		//$wi = $mi/$sh;
		//echo $wi."<br>";
		
		//$swfinal = ceil(($sw*$wi)/100);
		$shfinal = 65;
		//$swfinal = 98 ; 
		//echo $swfinal;
		//exit;
	}
	//else
	//{
		//echo "Both not Greater Than 300<br>";
		//$wi = $mi/$sw;
		//$shfinal = ceil(($wi*$sh)/100);
		if($sw < 100)
		{
			$swfinal = $sw ;	
		}
		if($sh < 65)
		{
			$shfinal = $sh ;
		}	
		
	//}
	
	//echo "Width:-".$swfinal." Orignal Width:-".$sw."<br>";
	//echo "Height:-".$shfinal." Orignal Height:-".$sh."<br>";
	//echo "Wi:-".$wi."<br>";
	//exit;
		
	$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG ($img) or // or PNG Image
	$im = @ImageCreateFromGIF ($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	if (!$im) {
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		readfile ($img);
	} else {
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($swfinal, $shfinal);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $swfinal, $shfinal, $sw, $sh);
		//@imagecopyresized($this->dest_image, $this->src_image, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		// Output resized image
		@ImageJPEG ($thumb,$dest.'/'.$filename);
		//if($thumb)copy($thumb,'thumb_'.$filename);
	}
}

function ImageResizeMain($img,$dest,$filename)
{
	$sh = 0;
	$sw = 0;
	$wi = 0;
	// get image size of img
	$x = @getimagesize($img);
	// image width
	$sw += $x[0];
	//echo $sw;
	//exit;
	// image height
	$sh = $x[1];
	$mi = 307*100;
	if($sw >= 350)
	{
		$wi =$mi/$sw;
		if($sh>275)
		{
			$shfinal = 275;
		}
		else
		{
			$shfinal = $sh;		
		}
		$swfinal = 350; 
	}
	elseif($sw < 350)
	{
		if($sh>275)
		{
			$shfinal = 275;
		}
		else
		{
			$shfinal = $sh;		
		}
		 //ceil(($wi*$sh)/100);
		$swfinal = $sw; // 300 ;	
	}
	
	if($sw>350)
	{
		$snew1 = ceil(($sw-$swfinal)/2);
		$snew = ceil($snew1/2);
	}
	else
	{
		$snew=0;
	}
	//echo "Width:-".$swfinal." Orignal Width:-".$sw."<br>";
	//echo "Height:-".$shfinal." Orignal Height:-".$sh."<br>";
	//echo "Wi:-".$wi."<br>";
	//exit;
		
	$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG ($img) or // or PNG Image
	$im = @ImageCreateFromGIF ($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	
	if (!$im) {
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		readfile ($img);
	} else {
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($swfinal, $shfinal);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $swfinal, $shfinal, $sw, $sh);
		//@imagecopyresized($this->dest_image, $this->src_image, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		// Output resized image
		@ImageJPEG ($thumb,$dest.'/'.$filename);
		//if($thumb)copy($thumb,'thumb_'.$filename);
	}
}
function ImageResizePopUp($img,$dest,$filename)
{
	//$img = $_GET['img'];
	//$percent = $_GET['percent'];
	/*$constrain = $_GET['constrain'];
	$w = $_GET['w'];
	$h = $_GET['h'];*/
	//Copy Org Image To Destination
	//@copy($img,$dest.'/'.$filename);
	
	$sh = 0;
	$sw = 0;
	$wi = 0;
	// get image size of img
	$x = @getimagesize($img);
	// image width
	$sw += $x[0];
	//echo $sw;
	//exit;
	// image height
	$sh = $x[1];
	
	$mi = 597*100;
	
	if($sw >= 597)
	{
		//echo "Width Greater Than 300<br>";
		$wi =$mi/$sw;
		$shfinal = ceil(($sh*$wi)/100);
		$swfinal = 597 ; 
	}
	/*elseif($sh >= 300)
	{
		//echo "height Greater Than 300<br>";
		//echo $mi."====".$sh."<br>";
		$wi = $mi/$sh;
		//echo $wi."<br>";
		
		$swfinal = ceil(($sw*$wi)/100);
		$shfinal = 300 ;
		//echo $swfinal;
		//exit;
	}*/
	elseif($sw < 597)
	{
		//echo "Both not Greater Than 300<br>";
		//$wi = $mi/$sw;
		$shfinal = $sh; //ceil(($wi*$sh)/100);
		$swfinal = $sw; // 300 ;	
	}
	//echo "Width:-".$swfinal." Orignal Width:-".$sw."<br>";
	//echo "Height:-".$shfinal." Orignal Height:-".$sh."<br>";
	//echo "Wi:-".$wi."<br>";
	//exit;
		
	$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
	$im = @ImageCreateFromPNG ($img) or // or PNG Image
	$im = @ImageCreateFromGIF ($img) or // or GIF Image
	$im = false; // If image is not JPEG, PNG, or GIF
	
	if (!$im) {
		// We get errors from PHP's ImageCreate functions...
		// So let's echo back the contents of the actual image.
		readfile ($img);
	} else {
		// Create the resized image destination
		$thumb = @ImageCreateTrueColor ($swfinal, $shfinal);
		// Copy from image source, resize it, and paste to image destination
		@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $swfinal, $shfinal, $sw, $sh);
		//@imagecopyresized($this->dest_image, $this->src_image, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
		// Output resized image
		@ImageJPEG ($thumb,$dest.'/'.$filename);
		//if($thumb)copy($thumb,'thumb_'.$filename);
	}
}
?>
