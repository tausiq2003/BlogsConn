


<?php

/* DATABASE CONNECTION*/


    define('DB_HOST', 'localhost:4306');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'blogsite');

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(!$connection) {
        die("Cannot Establish A Secure Connection To The Host Server At The Moment!");
    }





?>