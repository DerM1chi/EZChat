<?php

    if(isset($_POST["BUTTON_submit"])) {
        $userNameInput = strval($_POST["INPUT_userName"]);

        if(strlen($userNameInput) > 20 || strlen($userNameInput) < 3) {
            ?>

            <h1>choose a Username:</h1>
            <form method="post"">
                <input name="INPUT_userName" type="text" >
                <input name="BUTTON_submit" type="submit" value="Einloggen!" required>
            </form>

            <?php
            echo "<p style='color:red'>The username needs to be 3-20 characters long!</p>";
        } else {

            $userNameInput = system::replaceSpecialChars($userNameInput);

            $_SESSION["userName"] = $userNameInput;
            system::log("Username was registered");
            system::reloadPage();
        }
    } else {
        ?>

        <h1>choose a Username:</h1>
        <form method="post"">
            <input name="INPUT_userName" type="text" >
            <input name="BUTTON_submit" type="submit" value="Log in!" required>
        </form>

        <?php
    }
?>