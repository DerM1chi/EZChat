<?php

class chat
{
    public static function loadMessages($chatID) { //expects a string, then loads the contents of the file specified by the string
        return system::csvToArray("chat/" .  $chatID . ".csv");
        system::log("loaded Messages");
    }

    public static function createChat($chatID, $imageURL) { //expects 2 strings and uses them to create an entry in chatrooms.csv an create a new csv for the chat.
        //$chatID = urlencode($chatID);

        if(!file_exists("chat/" . $chatID . ".csv")) {
            fopen("chat/" . $chatID . ".csv", "w");

            $chatRoomArray = system::csvToArray("chat/chatrooms.csv");
            array_push($chatRoomArray, [$chatID, $imageURL]);

            system::arrayToCsv($chatRoomArray, "chat/chatrooms.csv", true);
            system::reloadPage();
        } else {
            echo "<p style='color: red'>This Chatroom already exists!</p>";
        }

    }

    public static function chatExists($chatID) {

        $chatArray = system::csvToArray("chat/chatrooms.csv");
        $returnValue = false;

        foreach ($chatArray as $chat) {
            if ($chatID === strtolower($chat[0])) {
                $returnValue = true;
            }
        }

        return $returnValue;

    }

    public static function sendMessage($chatID, $message)
    { // expects 2 strings, $chatID specifies the selected chat, message specidies the string to put in the chat file

        if ($message != "") {

            $sentMessages = system::csvToArray("chat/" . $chatID . ".csv");

            if(system::stringIsHTTPURL($message)) {
                $message = '<a href="' . $message . '">' . $message . '</a>';
            } else {
                $message = system::replaceSpecialChars($message);
            }

            array_push($sentMessages, [$_SESSION["userName"], $message, time()]);

            system::arrayToCsv($sentMessages, "chat/" . $chatID . ".csv", true);
            system::log("sent message '" . $message . "' in Chatroom '" . $chatID . "'");

        } else {
            system::log("User tried to send empty message");
        }
    }

    public static function convertToHumanTime( $unixTimeStamp ) {

        $returnArray = [];
        $timeDifference = time() - $unixTimeStamp;

        if ($timeDifference < 60) {
            $returnArray = [$timeDifference, "seconds"];
        } elseif ($timeDifference < 60 * 60) {
            $returnArray = [floor($timeDifference/60), "minutes"];
        } elseif ($timeDifference < 60 * 60 * 24) {
            $returnArray = [floor($timeDifference/60/60), "hours"];
        } elseif ($timeDifference < 60 * 60 * 24 * 7) {
            $returnArray = [floor($timeDifference/60/60/24), "days"];
        } elseif ($timeDifference < 60 * 60 * 24 * 30) {
            $returnArray = [floor($timeDifference/60/60/24/7), "weeks"];
        }else{
            $returnArray = [floor($timeDifference/60/60/24/30), "months"];
        }

        return $returnArray;

    }
}