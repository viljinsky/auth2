<?php

$sid = filter_input(INPUT_GET,'sid');
session_id($sid);
session_start();

$secret = $_SESSION['secret'];

$im = imagecreate(80, 31);
imageColorAllocate($im,255,255,255);
$textcolor = imagecolorallocate($im, 0,0,0);
imagestring($im,5,10,10,$secret, $textcolor );
imageGif($im); 
header("Content-Type: image/gif");

?>
