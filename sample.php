<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'api/vendor/autoload.php';

use FootballBlog\Processors\Encrypt;

$encrypt = new Encrypt();

echo $encrypt->encryptString("bri","very much");

function myShuffler($val){

}
?>