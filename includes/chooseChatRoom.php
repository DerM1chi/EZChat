<?php
    if(isset($_SESSION["userName"])) {
        ?>
        <form method="get" id="logoutContainer">
            <input type="submit" name="resetSession" value="Logout!" id="logout">
        </form>
        <?php
    }
?>
<h1>choose chatroom:</h1>
<div style="" id="chatRoomLinkParent">
    <?php
        $chatRoomArray = system::csvToArray("chat/chatrooms.csv");

        foreach ($chatRoomArray as $chatRoom) {
            echo "<a class='chatRoomLink' href='?chatRoom=" . strtolower($chatRoom[0]) . "'><img src='" .  $chatRoom[1] . "' alt='Bild' style='height: 100px;'/><p style='text-align: center'>" . $chatRoom[0] . "</p></a>";
        }
    ?>
</div>

<?php
    include_once "createChat.php";
?>
