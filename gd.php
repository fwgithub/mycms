<?php

header("Content-type: image/png");
$string = 'test';
$im     = imagecreatefrompng("./button1.png");
$orange = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
//imagestring($im, 3, $px, 9, $string, $orange);
//imagepng($im);
//imagedestroy($im);
$filename = 'someimage.png';
$left = 50;
$top = 50;
$current_width = 200;
$current_height = 200;
$canvas = imagecreatetruecolor($current_width, $current_height);
$pngg  = imagecopy($canvas, $im, 0, 0, $left, $top, $current_width, $current_height);
imagepng($canvas, $filename);

?>
