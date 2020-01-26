<?php
    include_once "includes/classes/system.php";
    include_once "includes/classes/chat.php";

    session_start();

    //kann genutzt werden um sich auszuloggen, während der Entwicklung der Seite
    if(isset($_GET["resetSession"])) {
        system::log("resetting Session!");
        if(isset($_SESSION["userName"])) {
            unset($_SESSION["userName"]);
        }
        system::log("Done!");
        header("location: {$_SERVER['PHP_SELF']}");
    }

    if(isset($_GET["clearLog"])) {
        system::clearLog();
        header("location: {$_SERVER['PHP_SELF']}");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
        if(isset($_SESSION["userName"])) {

            if(isset($_GET["chatRoom"])) {
                include_once "includes/chat.php";
            } else {
                include_once "includes/chooseChatRoom.php";
            }

        } else {
            include_once "includes/login.php";
        }

        if(isset($_GET["showLog"])) {
            system::showLog();
        }

        if(!isset($_GET["chatRoom"])) {
            include_once "includes/footer.php";
        }
    ?>
</body>
</html>