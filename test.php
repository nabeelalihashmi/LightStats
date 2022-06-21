<?php

$start_time = microtime(true);

include "vendor/autoload.php";

use IconicCodes\LightStats\LightStats;

$stats = new LightStats;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        * {
            margin: 0;
            padding: 0;
        }
        </style>
</head>
<body>
    <div style="background-image: url('https://images.unsplash.com/photo-1518791841217-8f162f1e1131?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">

</body>
</html>


<?php



$stats->showHtmlStatsBox($start_time);


?>