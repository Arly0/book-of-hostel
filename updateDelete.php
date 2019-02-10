<!doctype html>
<html>
<head>
    <title>Update/Delete</title>
    <meta charset="utf-8">
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
        body{
            text-align: center;
        }
        .hide{
            display:none;
        }
    </style>
</head>
<body><br>
    <form action="" method="post" >
        <input type="email" name="mail" placeholder="Enter your EMail"><br><br>
        <input type="password" name="password" placeholder="Your password"><br><br>
        <input type="submit" value="Send" name="submit"><br><br><br>
    </form>
<?php
include ("connect.php");
if(isset($_POST['submit']))
    watchMail($connection);

function watchMail($conn){
    $mail = htmlentities(strip_tags($_POST['mail']));
    $pass = htmlentities(strip_tags($_POST['password']));

    $queryFind = "SELECT * FROM `book` WHERE `email` = '$mail' AND `password` = '$pass'";
    $idArray = array();
    $result = mysqli_query($conn, $queryFind);
    if(mysqli_num_rows($result) == 0)
    {
        echo "Не найдено такого пользователя";
    }
    else
    {
        $num_rows = mysqli_num_rows($result);
        for($i=1;$i<=$num_rows;$i++) {

            $row = mysqli_fetch_assoc($result);
            $idArray[$i] = $row['id'];
            ?>
            <div id="container-<?=$i?>" class="container-<?=$i?>">
                <div class="container"><p class="comment"><?=$row['date']?></p></div>
                <br><textarea id="textarea-<?=$i?>" readonly cols="90" rows="10" id="comment" class="comment">
                    <?php
                    echo $row['message'];

                    ?>
                </textarea>
                <br><button onclick="document.getElementById('textarea-<?=$i?>').removeAttribute('readonly');">Update</button>
            <button onclick="if(confirm('Are u sure?   Delete this comment?')) {
                    document.getElementById('container-<?=$i?>').classList.toggle('hide');
                    <?php
                    // удаление происходит не определеннго коммента, а всех комментов юзера
                    $queryDelete = "DELETE FROM `book` WHERE `book`.`id` = $idArray[$i]";
                    mysqli_query($conn, $queryDelete);
                    ?>
                }">Delete</button>
            </div>

            <?php
        }
    }
}
        ?>


</body>
</html>
