<?php
$connection = mysqli_connect('localhost', 'root', '' , 'users');

// DB connection
if( $connection == false )
{
    echo 'Connection fault!';
    echo mysqli_connect_error();
    exit();
}
?>