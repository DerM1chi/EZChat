<?php

class system
{
    public static $version = "1.0";

    public static function log($strToLog = "") { //writes a string to the log File

        if (isset($_SESSION["userName"])) {
            $userName = $_SESSION["userName"];
        } else {
            $userName = "undefined";
        }

        if(!file_exists("log.txt")) {
            fopen("log.txt", "w");
            file_put_contents("log.txt", file_get_contents("log.txt") . "[" . date("Y/m/d h:i:s") . "][" . $_SERVER["REMOTE_ADDR"] . "][" . session_id() . "][" . $userName . "] " . $strToLog . PHP_EOL);
        } else {
            file_put_contents("log.txt", file_get_contents("log.txt") . "[" . date("Y/m/d h:i:s") . "][" . $_SERVER["REMOTE_ADDR"] . "][" . session_id() . "][" . $userName . "] " . $strToLog . PHP_EOL);
        }
    }

    public static function clearLog() { //replaces the content of log.txt with an empty string
        file_put_contents("log.txt", "");
        system::log("Logfile has been cleared!");
    }

    public static function showLog() {
        $logFileContent = file_get_contents("log.txt");
        system::log("showing Log File in Browser");
        echo "<p>Log File:</p><pre>{$logFileContent}</pre>";
    }

    public static function csvToArray($filePath)
    { //gets a path to csv file, and returns it as an array (2D only)
        system::log("Converting " . $filePath . " to an Array");
        $outputArray = [];

        $fileContent = file_get_contents($filePath);

        if ($fileContent != "") {

            $fileContentArray = explode(PHP_EOL,$fileContent);

            for ($i = 0; $i < count($fileContentArray); $i++) {
                $outputArray[$i] = explode(",", $fileContentArray[$i]);
            }

        } else {
            $outputArray = [];
        }

        system::log("done!");

        return $outputArray;
    }

    public static function arrayToCsv($array, $filePath, $overwrite = false) { //gets an array and converts it to a csv file (2D only)

        $csvText = "";

        for($j = 0; $j < count($array); $j++) {

            $subArray = $array[$j];

            for($i = 0; $i < count($subArray); $i++){

                $csvText = $csvText . $subArray[$i];

                if ($i + 1 != count($subArray)) {
                    $csvText = $csvText . ",";
                }

            }

            if ($j + 1 != count($array)) {
                $csvText = $csvText . PHP_EOL;
            }

        }

        if($overwrite == true) {
            file_put_contents($filePath, $csvText);
            system::log("writing Array to " . $filePath);
        }
        return $csvText;
    }

    public static function replaceSpecialChars($string) { // replaces "<", ">" and "," with their html charcode, so a message wont be interpreted as html tag
        $string = str_replace("<", "&lt;", $string);
        $string = str_replace(">", "&gt;", $string);
        $string = str_replace(",", "&sbquo;", $string);
        $string = str_replace(" ", "&nbsp;", $string);

        return $string;
    }

    public static function reloadPage() {
        system::log("reloading page...");
        header("Refresh:0");
    }

    public static function stringIsHTTPURL( $string) {

        $returnValue = false;

        if (filter_var($string, FILTER_VALIDATE_URL)) {
            $returnValue = true;
        }

        return $returnValue;

    }
}
?>