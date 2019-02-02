<?php

include ("generator.php");

//take cookie value(given in image.php) and capthca enter user
$captcha = $_COOKIE["captcha"];
$value = $_POST['text'];

function check_captcha($captcha,$cookie){
    // delete spaces and heshing it
    $captcha = trim($captcha);
    $captcha = md5($captcha);

    // check it
    if($captcha == $cookie)
        return true;
    else
        return false;
}

if(isset($_POST['submit'])) {

    //if field is clear
    if (isset($value) == '') {
        exit("Enter captcha pls!");
    }

    // if captcha coincide
    if (check_captcha($value, $captcha)) {
        echo('Good, u are not robot :) Welcome');
    }
    // not
    else {
        exit("Whrong captcha");
    }
}
// if do not go straight (oh no)
else{
    exit("OMG, its so bad, get out, hacker!");
}