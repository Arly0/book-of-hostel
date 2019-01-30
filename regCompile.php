<?php
include ("connect.php");

if(isset($_POST['submit']))
    getSign($connection);
function getSign($connection)
{
    $email = htmlentities(strip_tags($_POST['mail']));
    $password = htmlentities(strip_tags($_POST['passw']));

    $querySelect = "SELECT * FROM `book` WHERE `email` = '$email' AND `password` = '$password'";

    $result = mysqli_query($connection, $querySelect);
    if (mysqli_num_rows($result) == 0)
        exit("Unknow user");
    else
        include("index.php");
}
?>