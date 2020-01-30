<form method="post" id="exitButtonContainer">
    <input type="submit" name="BUTTON_EXIT" value="exit chatroom">
</form>

    <?php
        if (isset($_POST["BUTTON_EXIT"])) {
            header("location: {$_SERVER['PHP_SELF']}");
        }
        if(chat::chatExists($_GET["chatRoom"])) {
            echo '<div id="messagesContainer">';
            if (isset($_POST["BUTTON_SEND"])) {
                chat::sendMessage($_GET["chatRoom"], $_POST["INPUT_MESSAGE"]);
            }

            $messagesArray = chat::loadMessages($_GET["chatRoom"]);

            foreach ($messagesArray as $message) {
                echo "<div>";

                for ($i = 0; $i < count($message); $i++) {
                    if ($i != 2) {
                        echo "<p class='chatMessage" . $i . "'>" . $message[$i] . "</p>";
                    } else {
                        $timeArray = chat::convertToHumanTime($message[$i]);

                        echo "<p class='chatMessage" . $i . "'>" . $timeArray[0] . " " . $timeArray[1];

                        if($timeArray[0] > 1) {
                            echo "s ago</p>";
                        } else {
                            echo " ago</p>";
                        }

                    }
                }

                echo "</div>";
            }

            if (isset($_POST["BUTTON_RELOAD"])) {
                system::reloadPage();
            }

            ?>
        </div>
        <pre id="test"></pre>
        <div id="chatInputContainer">
            <form method="post">
                <input type="text" name="INPUT_MESSAGE" placeholder="Type something..." autocomplete="off"
                       id="chatInput">
                <input type="submit" name="BUTTON_SEND" value="Send" id="chatSendButton">
                <input type="submit" name="BUTTON_RELOAD" value="Reload" id="chatReloadButton">
            </form>
        </div>

        <script>

            var unixTimeStampFromServer = <?php echo time() ?>;

            function convertToHumanTime(unixTimeStamp) {

                let timeDifference = unixTimeStampFromServer - unixTimeStamp;
                let returnArray = [];

                if (timeDifference < 60) {
                    returnArray = [timeDifference, "second"];
                } else if (timeDifference < 60 * 60) {
                    returnArray = [Math.floor(timeDifference / 60), "minute"];
                } else if (timeDifference < 60 * 60 * 24) {
                    returnArray = [Math.floor(timeDifference / 60 / 60), "hour"];
                } else if (timeDifference < 60 * 60 * 24 * 7) {
                    returnArray = [Math.floor(timeDifference / 60 / 60 / 24), "day"];
                } else if (timeDifference < 60 * 60 * 24 * 30) {
                    returnArray = [Math.floor(timeDifference / 60 / 60 / 24 / 7), "week"];
                } else {
                    returnArray = [Math.floor(timeDifference / 60 / 60 / 24 / 30), "month"];
                }

                return returnArray;

            }

            document.getElementById("chatInput").focus();

            //updates chat every 5 seconds
            setInterval(function () {

                unixTimeStampFromServer += 5;

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        if (this.responseText != "") {

                            let responseText = this.responseText;

                            let responseTextAsArrays = responseText.split("\n");

                            var responseTextMessageArrays = [];

                            for (var i = 0; i < responseTextAsArrays.length; i++) {
                                responseTextMessageArrays.push(responseTextAsArrays[i].split(","));
                            }

                            document.getElementById("messagesContainer").innerHTML = "";

                            for (var i = 0; i < responseTextAsArrays.length; i++) {
                                document.getElementById("messagesContainer").innerHTML += "<div><p class='chatMessage0'>" + responseTextMessageArrays[i][0] + "</p><p class='chatMessage1'>" + responseTextMessageArrays[i][1] + "</p><p class='chatMessage2'>" + convertToHumanTime(responseTextMessageArrays[i][2])[0] + " " + convertToHumanTime(responseTextMessageArrays[i][2])[1] + " ago</div></div>"
                            }

                        }
                    }
                };
                xhttp.open("GET", "chat/<?php echo $_GET["chatRoom"]; ?>.csv", true);
                xhttp.setRequestHeader("Cache-Control", "no-cache, no-store, must-revalidate");
                xhttp.send();

            }, 5000);
            window.scrollTo(0, document.body.scrollHeight);
        </script>
        <?php
    } else {
        echo "<h1 style='color:red'>This chatroom does not exist!</h1>";
    }
?>