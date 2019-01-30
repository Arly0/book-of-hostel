<?php
include ("connect.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Book of hostel
    </title>
    <style>
        body,html{
            margin: 0;padding: 0;
        }
        .container{
            width: 50%;
            margin: 0 25% 0 25%;
            border: 1px solid #000;
            text-align: center;
        }
        .navigator{
            margin-top: 100px;
        }
        li{
            float: left;
            list-style-type: none;
            margin-right: 15px;
        }
    </style>
</head>
<body>
<form>

</form>

<?php
$length = 25;
$symbols = 1000;
$queryAll = "SELECT COUNT(1) FROM `book`";
$result = mysqli_query($connection,$queryAll);
$rows = mysqli_fetch_array($result)[0];
$pages = $length / $rows;


// нужно цикл брать до конца таблицы в БД, чтоб выводить все данные,а не только первые 25
for($i=1;$i<=$length;$i++) {
    ?>

    <div class="container">
        <p id="comment" class="comment">
            <?php
                $querySelect = "SELECT * FROM `book` WHERE `id` = '$i'";
                $result = mysqli_query($connection, $querySelect);
                while($row = mysqli_fetch_array($result)){
                    echo $row['message'];
                }
            ?>
        </p>
    </div>

    <?php
}
for($i=0;$i<ceil($pages);$i++){
?>
<nav class="navigator">
    <ul>
        <li><a href="index.php"><?php echo $i; ?></a></li>
        <li><a href="index.php"><?php echo $i+1; ?></a></li>
        <li>...</li>
        <li><a href="index.php"><?php echo ceil($pages); ?></a></li>
    </ul>
</nav>
<?php
}
?>
</body>
</html>