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
<form name="form" id="form" action="check.php" method="post" style="text-align: center">
    <br><br><input type="text" name="name" placeholder="Enter your NickName" maxlength="30" minlength="6"><br><br>
    <input type="email" name="mail" placeholder="Enter your EMail"><br><br>
    <input type="password" name="password" placeholder="Your password"><br><br>
    <textarea rows="6" cols="50" name="message" maxlength="200" placeholder="Enter comment(max 200 symbols)"></textarea>
    <br><br><img alt="Captcha" id="img-captcha" src="Image.php" width="150" height="70">
    <br>
    <input autocomplete="off" type="text" name="text" placeholder="Enter captcha">
    <br>
    <a href="" onclick="document.getElementById('img-captcha').src='Image.php'">Refresh captcha</a>
    <br><br><input type="submit" value="Send" name="submit"><br><br><br>
</form>
<form action="updateDelete.php" method="post" name="newForm" id="newForm" style="text-align: center">
    <input type="submit" name="gotoNewFunc" value="Update/Delete"><br><br>
</form>
<?php

?>

<?php
$length = 10; // limit comments on page
$queryAll = "SELECT COUNT(1) FROM `book`"; // take all comments

$result = mysqli_query($connection,$queryAll);
$totalRows = mysqli_fetch_array($result)[0]; // fint qantity comments

$pages = $totalRows / $length; // find quantity all pages
$pages = ceil($pages);

if (isset($_GET['page'])) $page=($_GET['page']-1); else $page=0; // make page

if($page>$pages) $page = $pages; // exception
if ($page<1) $page=0;
if(!is_numeric($page)) $page=0;
if (!isset($list)) $list=0;

$list = $page*$length; // start print comments
$result = mysqli_query($connection, "SELECT * FROM `book` LIMIT $list, $length");
$num_result = mysqli_num_rows($result);

for($i=1;$i<=$num_result;$i++) {
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
<!--navigator-->
<nav class="navigator">
    <ul>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. 1?>">1</a></li>
        <li>...</li>
        <?php if($page >= 1){ ?>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. ($page)?>"><?= $page ?></a></li>
        <?php } ?>
        <li><b><a style="color: red;" href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. $page?>"><?= ++$page ?></a></b></li>
        <?php if($page < $pages){ ?>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='. ($page+1)?>"><?= ++$page ?></a></li>
        <?php } ?>
        <li>...</li>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME'].'?page='.$pages?>"><?php echo $pages; ?></a></li>
    </ul>
</nav>
</body>
</html>