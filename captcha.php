<?php

define ( 'DOCUMENT_ROOT', dirname ( __FILE__ ) );
define("img_dir", DOCUMENT_ROOT."/theme/img/other/");

include("random.php");
$captcha = generate_code();

$cookie = md5($captcha);
$cookietime = time()+120;
setcookie("captcha", $cookie, $cookietime);
		
function img_code($code)
{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                   
		header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");         
		header("Cache-Control: post-check=0, pre-check=0", false);           
		header("Pragma: no-cache");                                           
		header("Content-Type:image/png");

		$linenum = rand(3, 7); 

		$img_arr = array(
						 "1.png"
		);

		$font_arr = array();
			$font_arr[0]["fname"] = "arial.ttf";
			$font_arr[0]["size"] = 20;

		$n = rand(0,sizeof($font_arr)-1);
		$img_fn = $img_arr[rand(0, sizeof($img_arr)-1)];
		$im = imagecreatefrompng (img_dir . $img_fn); 

		for ($i=0; $i<$linenum; $i++)
		{
			$color = imagecolorallocate($im, rand(0, 150), rand(0, 100), rand(0, 150));
			imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
		}
		$color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200));

			
		$x = 0;
		for($i = 0; $i < strlen($code); $i++) {
			$x+=13;
			$letter=substr($code, $i, 1);
			imagettftext ($im, $font_arr[$n]["size"], rand(0, 3), $x, rand(27, 34), $color, img_dir.$font_arr[$n]["fname"], $letter);
		}

		for ($i=0; $i<$linenum; $i++)
		{
			$color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
			imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
		}

		ImagePNG ($im);
		ImageDestroy ($im);
}
img_code($captcha)
?>