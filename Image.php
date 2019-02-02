<?php

define("PATH" , $_SERVER['DOCUMENT_ROOT']); // path in folder project
define ("img_dir", PATH."/project_book/img"); // path with img
define ("font_dir", PATH."/project_book/Fonts"); // path with fonts

include ("generator.php");

header ("Content-type: image/png"); // sey hhtp protocol we call picture

$captcha = generator_captcha();
// hesh cookie and set time live
$cookie = md5($captcha);
$cookieTime = time() + 120;
setcookie("captcha", $cookie, $cookieTime);

function img_generate($code){ // code - captcha
    $fontArr = array(
        11 => "/Arial.ttf",
        12 => "/Gabriola.ttf",
    );
    $backArr = array(
        11 => "/image1.png",
        12 => "/image2.png",
        13 => "/image3.png",
    );

    // how many lines we paint on image
    $lineum = rand(4,7);
    // symbols in uppercase
    $code = strtoupper($code);
    // random image
    $r = rand(11,13);
    // create image from png(wow)
    $im = imagecreatefrompng(img_dir.$backArr[$r]);
    // i made array of string for each symbol have original font, color, size
    $codeArr = str_split($code);
    // start coord
    $x = 0;

    // show text with random color,size, coordinates(coord next), font
    for ($i=0;$i<strlen($code);$i++)
    {
        $r = rand(11,12);
        $x += rand(15,25);
        $size = rand(20,30);
        $color = imagecolorallocate($im, rand(100,255), rand(100,255), rand(100,255));
        imagettftext($im, $size, rand(2,4), $x, rand(40,50), $color, font_dir.$fontArr[$r], $codeArr[$i]);
    }

    // paint lines on image, give them random start coord and end coord
    for ($i=0;$i<$lineum;$i++)
    {
        $x = rand(1,149);
        $y = rand(1,69);
        $x1 = rand(1,149);
        $y1 = rand(1,69);
        $color = imagecolorallocate($im, rand(100,255), rand(100,255), rand(100,255));
        imageline($im, $x, $y, $x1, $y1, $color);
    }

    //drow
    imagepng($im);
    imagedestroy($im);
}
img_generate($captcha);