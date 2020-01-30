<footer>
    <?php
        echo "<p>Version: " . system::$version . " | " .  $_SERVER['HTTP_USER_AGENT'] . "</p>";
        if(file_get_contents("http://updateapi.michelbarnich.com/?product=Chat") != system::$version) {
            echo "<p style='color:red'>Update available</p>";
        }
    ?>
    <p>copyright © 2019 - 2020 Michel Barnich</p>
</footer>

