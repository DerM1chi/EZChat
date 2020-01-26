<h1>create a chatroom</h1>
<form method="post">
    <table>
        <tr>
            <td>
                <input name="INPUT_chatRoomName" type="text" placeholder="Name" autocomplete="off"><br>
            </td>
        </tr>
        <tr>
            <td>
                <input name="INPUT_chatRoomImageURL" type="text" placeholder="Image URL" autocomplete="off"><br>
            </td>
        </tr>
    </table>
    <input name="BUTTON_submit" type="submit" value="create Chatroom" required autocomplete="off">
</form>

<?php

    if(isset($_POST["BUTTON_submit"]) && $_POST["INPUT_chatRoomImageURL"] != "" && $_POST["INPUT_chatRoomName"] != "" && system::stringIsHTTPURL($_POST["INPUT_chatRoomImageURL"])) {
        chat::createChat($_POST["INPUT_chatRoomName"], $_POST["INPUT_chatRoomImageURL"]);
    }

    if(isset($_POST["BUTTON_submit"])) {
        if (!isset($_POST["INPUT_chatRoomImageURL"]) || !system::stringIsHTTPURL($_POST["INPUT_chatRoomImageURL"])) {
            echo "<p style='color: red'>The given URL is not valid!</p>";
        }
        if($_POST["INPUT_chatRoomName"] == "") {
            echo "<p style='color: red'>The chatroom name cannot be empty</p>";
        }
    }
?>