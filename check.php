<?php
include ("connect.php");
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
        checkMail();
        $ip      = setIP();
        $browser = setBrowser();
        $message = htmlentities(strip_tags($_POST['message']));
        $mail    = htmlentities(strip_tags($_POST['mail']));
        $nick    = htmlentities(strip_tags($_POST['name']));
        $pass    = htmlentities(strip_tags($_POST['password']));
        sendMessage($connection, $message , $mail,$pass,$name, $ip, $browser);
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

function checkMail(){
    $pattern = "/\w{4,15}\@\w{3,10}\.\w{2,10}/i";
    $mail = htmlentities(strip_tags($_POST['mail']));
    if(!preg_match($pattern,$mail))
        exit ("Invalid Mail");
}

function setIP(){
    // get ip
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
    else $ip = $remote;

    return $ip;
}

function setBrowser(){
    $user_agent = $_SERVER["HTTP_USER_AGENT"];
    if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
    elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
    elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
    elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
    elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
    else $browser = "Неизвестный";
    return $browser;
}

function sendMessage($connection, $message , $mail,$pass,$name, $ip, $browser){
    $dateTime = date('Y-m-d');
    $queryInsert = "INSERT INTO `book` (`message`, `email` ,`password`, `userName` `IP`, `browser`, `date`) VALUES ('$message', '$mail','$pass' , '$name', '$ip', '$browser', '$dateTime')";
    $result = mysqli_query($connection,$queryInsert);
    if($result) {
        echo 'Your comment is added';
    }
    else
        echo ('Something wrong. Try again later: ' . mysqli_error($connection));
    echo "<br><a href='index.php'>Back in menu</a>";
}