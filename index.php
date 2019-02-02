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
            margin: 100px 40% 100px 40%;
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
$linkLimit = 3;
$length = 10;
$symbols = 1000;
$queryAll = "SELECT COUNT(1) FROM `book`";
$result = mysqli_query($connection,$queryAll);
$totalRows = mysqli_fetch_array($result)[0];
$pages = $totalRows / $length;
$pages = ceil($pages);

if (isset($_GET['page'])) $page=($_GET['page']-1); else $page=0;
if($page>$pages) $page = $pages;
if ($_GET['page']<1) $page=0;
if(!is_numeric($page)) $page=0;
if (!isset($list)) $list=0;
$list = $page*$length;
$result = mysqli_query($connection, "SELECT * FROM `book` LIMIT $list, $length");

// нужно цикл брать до конца таблицы в БД, чтоб выводить все данные,а не только первые 25
for($i=1;$i<=$length;$i++) {
    ?>

    <div class="container">
        <p id="comment" class="comment">
            <?php
                $row = mysqli_fetch_assoc($result);
                    echo $row['message'];

            ?>
        </p>
    </div>

    <?php
}
?>
<nav class="navigator">
    <ul>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. 1?>">1</a></li>
        <li>...</li>
        <?php if($page >= 1){ ?>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. ($page)?>"><?= $page ?></a></li>
        <?php } ?>
        <li><b><a style="color: red;" href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. $page?>"><?= ++$page ?></a></b></li>
        <?php if($page < $pages){ ?>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. ($page+1)?>"><?= (1 + $page) ?></a></li>
        <?php } ?>
        <li>...</li>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='.$pages?>"><?php echo $pages; ?></a></li>
    </ul>
</nav>
</body>
</html>