<?php

session_start();

//Just upload this script to your server and link to it using a regular img tag e.g.
//<img src="verify.php" />
//This will give you your random image

/* set up image, the first number is the width and the second is the height*/
Header ("Content-type: image/jpeg");
$im = ImageCreate(160, 50);

/*creates two variables to store color*/
$white = ImageColorAllocate($im, 255, 255, 255);
$black = ImageColorAllocate($im, 50, 50, 50);

/*random string generator.*/
$string = rand(0,99999);

/*Runs the string through the md5 function*/
$string = md5($string);

/*creates the new string. */
$new_string = substr($string, 13, 5);

$new_string = str_replace('o', 'x', $new_string);
$new_string = str_replace('0', 'y', $new_string);

$_SESSION['c_verify'] = $new_string;

/*fill image with black*/
ImageFill($im, 0, 0, $black);

/*writes string */
//ImageString($im, 20, 20, 10, $new_string, $white);

$font = '../fonts/NEWDAY.TTF';

imagettftext($im, 24, 2, 34, 36, $white, $font, $new_string);

/* output to browser*/
ImageJPeG($im, "", 100);

ImageDestroy($im);
?>